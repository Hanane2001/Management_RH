<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveBalance;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LeaveBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->isManager() && !auth()->user()->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }
        $balances = LeaveBalance::with('employee')->orderBy('year', 'desc')->orderBy('remaining_days', 'desc')->paginate(20);
        return view('leave_balances.index', compact('balances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Seul l\'administrateur peut créer des soldes');
        }
        $employees = User::whereHas('role', function($q) {
            $q->where('name', 'employ');
        })->get();
        return view('leave_balances.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
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
            return back()->with('error', 'Un solde existe déjà pour cet employé pour l\'année ' . $request->year);
        }
        $remaining_days = $request->total_days - $request->used_days;
        LeaveBalance::create([
            'employee_id' => $request->employee_id,
            'year' => $request->year,
            'total_days' => $request->total_days,
            'used_days' => $request->used_days,
            'remaining_days' => $remaining_days
        ]);
        return redirect()->route('leave-balances.index')->with('success', 'Solde créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(LeaveBalance $leaveBalance)
    {
        $user = auth()->user();
        if ($user->isEmployee() && $leaveBalance->employee_id !== $user->id) {
            abort(403);
        }
        
        if (!$user->isManager() && !$user->isAdmin() && $leaveBalance->employee_id !== $user->id) {
            abort(403);
        }
        
        $leaveBalance->load('employee');
        return view('leave_balances.show', compact('leaveBalance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaveBalance $leaveBalance)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Seul l\'administrateur peut modifier les soldes');
        }
        
        $employees = User::whereHas('role', function($q) {
            $q->where('name', 'employ');
        })->get();
        
        return view('leave_balances.edit', compact('leaveBalance', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeaveBalance $leaveBalance)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'year' => 'required|integer|min:2000|max:2030',
            'total_days' => 'required|integer|min:1|max:365',
            'used_days' => 'required|integer|min:0'
        ]);

        $exists = LeaveBalance::where('employee_id', $request->employee_id)->where('year', $request->year)->where('id', '!=', $leaveBalance->id)->exists();
        if ($exists) {
            return back()->with('error', 'Un solde existe déjà pour cet employé pour l\'année ' . $request->year);
        }
        $remaining_days = $request->total_days - $request->used_days;
        $leaveBalance->update([
            'employee_id' => $request->employee_id,
            'year' => $request->year,
            'total_days' => $request->total_days,
            'used_days' => $request->used_days,
            'remaining_days' => $remaining_days
        ]);
        
        return redirect()->route('leave-balances.index')->with('success', 'Solde mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeaveBalance $leaveBalance)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $leaveBalance->delete();
        return redirect()->route('leave-balances.index')->with('success', 'Solde supprimé avec succès');
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
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $currentYear = date('Y');
        $defaultDays = 30;
        $employees = User::whereHas('role', function($q) {
            $q->where('name', 'employ');
        })->get();
        
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
        
        return redirect()->route('leave-balances.index')->with('success', "Soldes initialisés: $created créés, $skipped existants");
    }

    public function resetForNewYear(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $request->validate([
            'year' => 'required|integer|min:' . date('Y') . '|max:2030',
            'default_days' => 'required|integer|min:1|max:365'
        ]);
        
        $employees = User::whereHas('role', function($q) {
            $q->where('name', 'employ');
        })->get();
        
        $created = 0;
        foreach ($employees as $employee) {
            LeaveBalance::create([
                'employee_id' => $employee->id,
                'year' => $request->year,
                'total_days' => $request->default_days,
                'used_days' => 0,
                'remaining_days' => $request->default_days
            ]);
            $created++;
        }
        
        return redirect()->route('leave-balances.index')->with('success', "Soldes pour l'année {$request->year} créés pour $created employés");
    }
    public function export()
    {
        if (!auth()->user()->isManager() && !auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $balances = LeaveBalance::with('employee')->where('year', date('Y'))->get();
        $filename = "soldes_conges_" . date('Y') . ".csv";
        $handle = fopen('php://temp', 'w');
        fputcsv($handle, ['Employé', 'Email', 'Département', 'Total', 'Utilisés', 'Restant', 'Utilisation (%)']);
        foreach ($balances as $balance) {
            fputcsv($handle, [
                $balance->employee->first_name . ' ' . $balance->employee->last_name,
                $balance->employee->email,
                $balance->employee->department->name ?? 'N/A',
                $balance->total_days,
                $balance->used_days,
                $balance->remaining_days,
                number_format($balance->getUsedPercentage(), 2)
            ]);
        }
        
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);
        return response($csv, 200)->header('Content-Type', 'text/csv')->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function addDays(Request $request, LeaveBalance $leaveBalance)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $request->validate([
            'days' => 'required|integer|min:1'
        ]);
        
        $leaveBalance->update([
            'total_days' => $leaveBalance->total_days + $request->days,
            'remaining_days' => $leaveBalance->remaining_days + $request->days
        ]);
        
        return back()->with('success', "{$request->days} jours ajoutés au solde");
    }

    public function statistics()
    {
        if (!auth()->user()->isManager() && !auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $currentYear = date('Y');
        
        $stats = [
            'total_employees' => User::whereHas('role', fn($q) => $q->where('name', 'employ'))->count(),
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
