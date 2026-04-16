<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\LeaveBalance;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin() || $user->isManager()) {
            $leaves = Leave::with(['employee', 'processedBy'])->latest()->paginate(10);
        } else {
            $leaves = Leave::with('processedBy')->where('employee_id', $user->id)->latest()->paginate(10);
        }
        return view('leaves.index', compact('leaves'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        $balance = LeaveBalance::where('employee_id', $user->id)->where('year', date('Y'))->first();
        if (!$balance) {
            $balance = LeaveBalance::create([
                'employee_id' => $user->id,
                'year' => date('Y'),
                'total_days' => 30,
                'used_days' => 0,
                'remaining_days' => 30
            ]);
        }
        return view('leaves.create', compact('balance'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:paid,sick,unpaid,exceptional',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string|max:500'
        ]);
        
        $user = auth()->user();
        $startDate = new \DateTime($request->start_date);
        $endDate = new \DateTime($request->end_date);
        $duration = $startDate->diff($endDate)->days + 1;

        if ($request->type === 'paid') {
            $balance = LeaveBalance::where('employee_id', $user->id)->where('year', date('Y'))->first();
            
            if (!$balance || $balance->remaining_days < $duration) {
                return back()->with('error', 'Solde de congés insuffisant. Solde restant: ' . ($balance->remaining_days ?? 0) . ' jours');
            }
        }
        Leave::create([
            'employee_id' => $user->id,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'duration' => $duration,
            'reason' => $request->reason,
            'status' => 'pending',
            'request_date' => now()
        ]);
        return redirect()->route('leaves.index')->with('success', 'Demande de congé envoyée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Leave $leave)
    {
        $user = auth()->user();
            if ($user->isEmployee() && $leave->employee_id !== $user->id) {
            abort(403);
        }
        if (!$user->isManager() && !$user->isAdmin() && $leave->employee_id !== $user->id) {
            abort(403);
        }
        $leave->load(['employee', 'processedBy']);
        return view('leaves.show', compact('leave'));
    }

    public function approve(Leave $leave)
    {
        if (Gate::denies('process', $leave)) {
            abort(403);
        }
        if (!$leave->isPending()) {
            return back()->with('error', 'Cette demande a déjà été traitée');
        }
        DB::transaction(function () use ($leave) {
            $leave->update([
                'status' => 'approved',
                'processed_date' => now(),
                'processed_by' => auth()->id()
            ]);
            if ($leave->type === 'paid') {
                $balance = LeaveBalance::firstOrCreate(
                    [
                        'employee_id' => $leave->employee_id,
                        'year' => date('Y', strtotime($leave->start_date))
                    ],
                    [
                        'total_days' => 30,
                        'used_days' => 0,
                        'remaining_days' => 30
                    ]
                );
                $balance->useDays($leave->duration);
            }
        });
        
        return redirect()->route('leaves.index')->with('success', 'Demande de congé approuvée');
    }

    public function reject(Leave $leave)
    {
        if (Gate::denies('process', $leave)) {
            abort(403);
        }
        if (!$leave->isPending()) {
            return back()->with('error', 'Cette demande a déjà été traitée');
        }
        $leave->update([
            'status' => 'rejected',
            'processed_date' => now(),
            'processed_by' => auth()->id()
        ]);
        
        return redirect()->route('leaves.index')->with('success', 'Demande de congé refusée');
    }

    public function balance()
    {
        $user = auth()->user();
        $balances = LeaveBalance::where('employee_id', $user->id)->orderBy('year', 'desc') ->get();
        $currentBalance = $balances->first();
        return view('leaves.balance', compact('balances', 'currentBalance'));
    }

    public function allBalances()
    {
        if (Gate::denies('viewAny', LeaveBalance::class)) {
            abort(403);
        }
        $balances = LeaveBalance::with('employee')->where('year', date('Y'))->orderBy('remaining_days', 'desc')->paginate(20);
        return view('leaves.all-balances', compact('balances'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {
        //
    }
}
