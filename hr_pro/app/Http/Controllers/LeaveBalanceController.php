<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveBalance;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class LeaveBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('viewAny', LeaveBalance::class)) {
            abort(403);
        }
        $balances = LeaveBalance::with('employee')->orderBy('year', 'desc')->orderBy('remaining_days', 'desc')->paginate(20);
        return view('leave_balances.index', compact('balances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', LeaveBalance::class)) {
            abort(403);
        }
        $employees = User::where('role_id', User::ROLE_EMPLOYEE)->get();
        return view('leave_balances.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('create', LeaveBalance::class)) {
            abort(403);
        }
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'year' => 'required|integer|min:2000|max:2030',
            'total_days' => 'required|integer|min:1|max:365',
            'used_days' => 'required|integer|min:0'
        ]);
        $exists = LeaveBalance::where('employee_id', $request->employee_id)->where('year', $request->year)->exists();
        if ($exists) {
            return back()->with('error', 'Balance already exists for this year');
        }
        $remaining_days = $request->total_days - $request->used_days;
        LeaveBalance::create([
            'employee_id' => $request->employee_id,
            'year' => $request->year,
            'total_days' => $request->total_days,
            'used_days' => $request->used_days,
            'remaining_days' => $remaining_days
        ]);
        return redirect()->route('leave-balances.index')->with('success', 'Leave balance created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(LeaveBalance $leaveBalance)
    {
        if (Gate::denies('view', $leaveBalance)) {
            abort(403);
        }
        return view('leave_balances.show', compact('leaveBalance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaveBalance $leaveBalance)
    {
        if (Gate::denies('update', $leaveBalance)) {
            abort(403);
        }
        $employees = User::where('role_id', User::ROLE_EMPLOYEE)->get();
        
        return view('leave_balances.edit', compact('leaveBalance', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeaveBalance $leaveBalance)
    {
        if (Gate::denies('update', $leaveBalance)) {
            abort(403);
        }
        
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'year' => 'required|integer|min:2000|max:2030',
            'total_days' => 'required|integer|min:1|max:365',
            'used_days' => 'required|integer|min:0'
        ]);
        $remaining_days = $request->total_days - $request->used_days;
        $leaveBalance->update([
            'employee_id' => $request->employee_id,
            'year' => $request->year,
            'total_days' => $request->total_days,
            'used_days' => $request->used_days,
            'remaining_days' => $remaining_days
        ]);
        
        return redirect()->route('leave-balances.index')->with('success', 'Leave balance updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeaveBalance $leaveBalance)
    {
        if (Gate::denies('delete', $leaveBalance)) {
            abort(403);
        }
        
        $leaveBalance->delete();
        return redirect()->route('leave-balances.index')->with('success', 'Leave balance deleted successfully');
    }

    public function myBalance()
    {
        $user = auth()->user();
        
        $currentBalance = LeaveBalance::where('employee_id', $user->id)->where('year', date('Y'))->first();
        $balances = LeaveBalance::where('employee_id', $user->id)->orderBy('year', 'desc')->get();
        return view('leave_balances.my-balance', compact('currentBalance', 'balances'));
    }

    public function initializeYear()
    {
        if (Gate::denies('initialize', LeaveBalance::class)) {
            abort(403);
        }
        
        $currentYear = date('Y');
        $defaultDays = 30;
        $employees = User::where('role_id', User::ROLE_EMPLOYEE)->get();
        
        $created = 0;
        $skipped = 0;
        
        foreach ($employees as $employee) {
            $exists = LeaveBalance::where('employee_id', $employee->id)->where('year', $currentYear)->exists();
            if (!$exists) {
                LeaveBalance::create([
                    'employee_id' => $employee->id,
                    'year' => $currentYear,
                    'total_days' => $defaultDays,
                    'used_days' => 0,
                    'remaining_days' => $defaultDays
                ]);
                $created++;
            } else {
                $skipped++;
            }
        }
        
        return redirect()->route('leave-balances.index')->with('success', "Balances initialized: $created created, $skipped existing");
    }

    public function addDays(Request $request, LeaveBalance $leaveBalance)
    {
        if (Gate::denies('addDays', LeaveBalance::class)) {
            abort(403);
        }
        
        $request->validate([
            'days' => 'required|integer|min:1'
        ]);
        
        $leaveBalance->update([
            'total_days' => $leaveBalance->total_days + $request->days,
            'remaining_days' => $leaveBalance->remaining_days + $request->days
        ]);
        
        return back()->with('success', "{$request->days} days added to balance");
    }

    public function statistics()
    {
        if (Gate::denies('viewAny', LeaveBalance::class)) {
            abort(403);
        }
        
        $currentYear = date('Y');
        
        $stats = [
            'total_employees' => User::where('role_id', User::ROLE_EMPLOYEE)->count(),
            'total_balances' => LeaveBalance::where('year', $currentYear)->count(),
            'total_days_allocated' => LeaveBalance::where('year', $currentYear)->sum('total_days'),
            'total_days_used' => LeaveBalance::where('year', $currentYear)->sum('used_days'),
            'employees_with_low_balance' => LeaveBalance::where('year', $currentYear)->where('remaining_days', '<', 5)->count(),
            'employees_with_zero_balance' => LeaveBalance::where('year', $currentYear)->where('remaining_days', 0)->count(),
        ];
        $lowBalances = LeaveBalance::with('employee')->where('year', $currentYear)->where('remaining_days', '<', 5)->orderBy('remaining_days', 'asc')->take(10)->get();
        return view('leave_balances.statistics', compact('stats', 'lowBalances'));
    }
}
