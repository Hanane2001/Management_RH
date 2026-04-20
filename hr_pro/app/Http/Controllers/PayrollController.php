<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\User;
use App\Models\Contract;
use App\Models\Attendance;
use App\Http\Requests\StorePayrollRequest;
use App\Http\Requests\UpdatePayrollRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use PDF;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);
        
        if ($user->isAdmin()) {
            $payrolls = Payroll::with('employee')->where('month', $month)->where('year', $year)->latest()->paginate(15);
        } elseif ($user->isManager()) {
            $employeeIds = User::where('role_id', User::ROLE_EMPLOYEE)->pluck('id');
            $payrolls = Payroll::with('employee')->whereIn('employee_id', $employeeIds)->where('month', $month)->where('year', $year)->latest()->paginate(15);
        } else {
            $payrolls = Payroll::with('employee')->where('employee_id', $user->id)->where('month', $month)->where('year', $year)->latest()->paginate(15);
        }
        
        $months = $this->getMonthsList();
        $years = range(2020, Carbon::now()->year);
        
        return view('payrolls.index', compact('payrolls', 'month', 'year', 'months', 'years'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', Payroll::class)) {
            abort(403);
        }
        
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $employees = User::where('role_id', User::ROLE_EMPLOYEE)->with('contracts')->get();
        } else {
            $employees = User::where('department_id', $user->department_id)->where('role_id', User::ROLE_EMPLOYEE)->with('contracts')->get();
        }
        
        $months = $this->getMonthsList();
        $years = range(2020, Carbon::now()->year);
        
        return view('payrolls.create', compact('employees', 'months', 'years'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePayrollRequest $request)
    {
        if (Gate::denies('create', Payroll::class)) {
            abort(403);
        }

        $exists = Payroll::where('employee_id', $request->employee_id)->where('month', $request->month)->where('year', $request->year)->exists();
        if ($exists) {
            return back()->with('error', 'Payroll already exists for this employee for this period')->withInput();
        }
        
        $data = $request->validated();
        $data['net_pay'] = $this->calculateNetPay($data);
        
        Payroll::create($data);
        
        return redirect()->route('payrolls.index')->with('success', 'Payroll created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payroll $payroll)
    {
        if (Gate::denies('view', $payroll)) {
            abort(403);
        }
        
        $payroll->load('employee');
        return view('payrolls.show', compact('payroll'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payroll $payroll)
    {
        if (Gate::denies('update', $payroll)) {
            abort(403);
        }
        
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $employees = User::where('role_id', User::ROLE_EMPLOYEE)->get();
        } else {
            $employees = User::where('department_id', $user->department_id)->where('role_id', User::ROLE_EMPLOYEE)->get();
        }
        
        $months = $this->getMonthsList();
        $years = range(2020, Carbon::now()->year);
        
        return view('payrolls.edit', compact('payroll', 'employees', 'months', 'years'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePayrollRequest  $request, Payroll $payroll)
    {
        if (Gate::denies('update', $payroll)) {
            abort(403);
        }
        
        $data = $request->validated();
        if (isset($data['base_salary']) || isset($data['bonuses']) || 
            isset($data['allowances']) || isset($data['deductions']) || 
            isset($data['overtime_hours'])) {
            
            $data['net_pay'] = $this->calculateNetPay(array_merge($payroll->toArray(), $data));
        }
        
        $payroll->update($data);
        
        return redirect()->route('payrolls.index')->with('success', 'Payroll updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payroll $payroll)
    {
        if (Gate::denies('delete', $payroll)) {
            abort(403);
        }
        
        $payroll->delete();
        
        return redirect()->route('payrolls.index')->with('success', 'Payroll deleted successfully');
    }

    public function generateFromContract(Request $request)
    {
        if (Gate::denies('create', Payroll::class)) {
            abort(403);
        }
        
        $employeeId = $request->employee_id;
        $month = $request->month;
        $year = $request->year;
        $contract = Contract::where('employee_id', $employeeId)->whereNull('end_date')->first();
        
        if (!$contract) {
            return back()->with('error', 'No active contract found for this employee');
        }

        $overtimeHours = $this->calculateOvertimeHours($employeeId, $month, $year);
        
        $payrollData = [
            'employee_id' => $employeeId,
            'month' => $month,
            'year' => $year,
            'base_salary' => $contract->base_salary,
            'overtime_hours' => $overtimeHours,
            'bonuses' => 0,
            'allowances' => 0,
            'deductions' => 0,
            'status' => 'draft'
        ];
        
        $payrollData['net_pay'] = $this->calculateNetPay($payrollData);
        
        $payroll = Payroll::create($payrollData);
        
        return redirect()->route('payrolls.edit', $payroll)->with('success', 'Payroll generated from contract. You can now add bonuses, allowances, etc.');
    }

    public function generateAll(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $month = $request->month;
        $year = $request->year;
        
        $employees = User::where('role_id', User::ROLE_EMPLOYEE)->get();
        $created = 0;
        $skipped = 0;
        
        foreach ($employees as $employee) {
            $exists = Payroll::where('employee_id', $employee->id)->where('month', $month)->where('year', $year)->exists();
            
            if (!$exists) {
                $contract = Contract::where('employee_id', $employee->id)->whereNull('end_date')->first();
                
                if ($contract) {
                    $overtimeHours = $this->calculateOvertimeHours($employee->id, $month, $year);
                    
                    Payroll::create([
                        'employee_id' => $employee->id,
                        'month' => $month,
                        'year' => $year,
                        'base_salary' => $contract->base_salary,
                        'overtime_hours' => $overtimeHours,
                        'bonuses' => 0,
                        'allowances' => 0,
                        'deductions' => 0,
                        'status' => 'draft',
                        'net_pay' => $contract->base_salary
                    ]);
                    $created++;
                } else {
                    $skipped++;
                }
            } else {
                $skipped++;
            }
        }
        
        return redirect()->route('payrolls.index')->with('success', "Generated $created payrolls. Skipped $skipped (already exist or no contract)");
    }

    public function approve(Payroll $payroll)
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isManager()) {
            abort(403);
        }
        
        if (!$payroll->canBeApproved()) {
            return back()->with('error', 'Only generated payrolls can be approved');
        }
        
        $payroll->update(['status' => 'approved']);
        
        return redirect()->route('payrolls.index')->with('success', 'Payroll approved successfully');
    }

    public function markAsPaid(Payroll $payroll)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        if (!$payroll->canBePaid()) {
            return back()->with('error', 'Only approved payrolls can be marked as paid');
        }
        
        $payroll->update(['status' => 'paid']);
        
        return redirect()->route('payrolls.index')->with('success', 'Payroll marked as paid');
    }

    public function generatePdf(Payroll $payroll)
    {
        if (Gate::denies('view', $payroll)) {
            abort(403);
        }
        
        $payroll->load('employee');
        
        $pdf = PDF::loadView('payrolls.pdf', compact('payroll'));
        
        return $pdf->download("payroll_{$payroll->employee->first_name}_{$payroll->month}_{$payroll->year}.pdf");
    }

    public function export(Request $request)
    {
        if (Gate::denies('viewAny', Payroll::class)) {
            abort(403);
        }
        
        $user = auth()->user();
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);
        
        if ($user->isAdmin()) {
            $payrolls = Payroll::with('employee')->where('month', $month)->where('year', $year)->get();
        } elseif ($user->isManager()) {
            $employeeIds = User::where('department_id', $user->department_id)->where('role_id', User::ROLE_EMPLOYEE)->pluck('id');
            $payrolls = Payroll::with('employee')->whereIn('employee_id', $employeeIds)->where('month', $month)->where('year', $year)->get();
        } else {
            $payrolls = Payroll::with('employee')->where('employee_id', $user->id)->where('month', $month)->where('year', $year)->get();
        }
        
        $filename = "payrolls_{$year}_{$month}.csv";
        $handle = fopen('php://temp', 'w');
        
        fputcsv($handle, ['Employee', 'Month', 'Year', 'Base Salary', 'Overtime Hours', 'Bonuses', 'Allowances', 'Deductions', 'Net Pay', 'Status']);
        
        foreach ($payrolls as $payroll) {
            fputcsv($handle, [
                $payroll->employee->first_name . ' ' . $payroll->employee->last_name,
                $payroll->getMonthName(),
                $payroll->year,
                $payroll->base_salary,
                $payroll->overtime_hours,
                $payroll->bonuses,
                $payroll->allowances,
                $payroll->deductions,
                $payroll->net_pay,
                $payroll->status
            ]);
        }
        
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);
        
        return response($csv, 200)->header('Content-Type', 'text/csv')->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }

    private function calculateNetPay($data)
    {
        $total = $data['base_salary'] + ($data['bonuses'] ?? 0) + ($data['allowances'] ?? 0);

        if (isset($data['overtime_hours']) && $data['overtime_hours'] > 0) {
            $dailyRate = $data['base_salary'] / 22;
            $hourlyRate = $dailyRate / 8;
            $total += $data['overtime_hours'] * $hourlyRate * 1.5;
        }
        
        $deductions = $data['deductions'] ?? 0;
        
        return $total - $deductions;
    }

    private function calculateOvertimeHours($employeeId, $month, $year)
    {
        $attendances = Attendance::where('employee_id', $employeeId)->whereYear('date', $year)->whereMonth('date', $month)->get();
        $overtime = 0;
        foreach ($attendances as $attendance) {
            if ($attendance->hours_worked > 8) {
                $overtime += ($attendance->hours_worked - 8);
            }
        }
        
        return round($overtime);
    }

    private function getMonthsList()
    {
        return [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];
    }
}
