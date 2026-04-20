<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        
        if ($user->isAdmin()) {
            $attendances = Attendance::with('employee')->whereDate('date', $date)->latest()->paginate(20);
        } elseif ($user->isManager()) {
            $employeeIds = User::where('department_id', $user->department_id)->where('role_id', User::ROLE_EMPLOYEE)->pluck('id');
            $attendances = Attendance::with('employee')->whereIn('employee_id', $employeeIds)->whereDate('date', $date)->latest()->paginate(20);
        } else {
            $attendances = Attendance::with('employee')->where('employee_id', $user->id)->whereDate('date', $date)->latest()->paginate(20);
        }
        
        $employees = $this->getEmployeesList();
        
        return view('attendances.index', compact('attendances', 'employees', 'date'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', Attendance::class)) {
            abort(403);
        }
        
        $employees = $this->getEmployeesList();
        $today = Carbon::today()->format('Y-m-d');
        
        return view('attendances.create', compact('employees', 'today'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendanceRequest  $request)
    {
        if (Gate::denies('create', Attendance::class)) {
            abort(403);
        }

        $exists = Attendance::where('employee_id', $request->employee_id)->whereDate('date', $request->date)->exists();
        
        if ($exists) {
            return back()->with('error', 'Attendance already recorded for this employee on this date')->withInput();
        }
        
        $data = $request->validated();
        if ($request->check_in) {
            $data['check_in'] = Carbon::parse($request->date . ' ' . $request->check_in);
        }
        if ($request->check_out) {
            $data['check_out'] = Carbon::parse($request->date . ' ' . $request->check_out);
        }
        
        $attendance = Attendance::create($data);

        if ($attendance->check_in && $attendance->check_out) {
            $attendance->calculateHoursWorked();
        }
        
        return redirect()->route('attendances.index')->with('success', 'Attendance recorded successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        if (Gate::denies('view', $attendance)) {
            abort(403);
        }
        
        $attendance->load('employee');
        return view('attendances.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        if (Gate::denies('update', $attendance)) {
            abort(403);
        }
        
        $employees = $this->getEmployeesList();
        
        return view('attendances.edit', compact('attendance', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        if (Gate::denies('update', $attendance)) {
            abort(403);
        }
        
        $data = $request->validated();
        $date = $request->date ?? $attendance->date->format('Y-m-d');
        
        if ($request->has('check_in') && $request->check_in) {
            $data['check_in'] = Carbon::parse($date . ' ' . $request->check_in);
        }
        if ($request->has('check_out') && $request->check_out) {
            $data['check_out'] = Carbon::parse($date . ' ' . $request->check_out);
        }
        
        $attendance->update($data);
        $attendance->calculateHoursWorked();
        
        return redirect()->route('attendances.index')->with('success', 'Attendance updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        if (Gate::denies('delete', $attendance)) {
            abort(403);
        }
        
        $attendance->delete();
        
        return redirect()->route('attendances.index')->with('success', 'Attendance deleted successfully');
    }

    public function checkIn()
    {
        $user = auth()->user();
        $today = Carbon::today();
        $attendance = Attendance::where('employee_id', $user->id)->whereDate('date', $today)->first();
        
        if ($attendance && $attendance->check_in) {
            return back()->with('error', 'You already checked in today at ' . $attendance->getCheckInFormatted());
        }
        
        if (!$attendance) {
            $attendance = new Attendance();
            $attendance->employee_id = $user->id;
            $attendance->date = $today;
            $attendance->status = 'present';
        }
        
        $attendance->check_in = Carbon::now();
        $attendance->save();
        
        return redirect()->route('dashboard')->with('success', 'Checked in successfully at ' . Carbon::now()->format('H:i:s'));
    }

    /**
     * Check-out for current user.
     */
    public function checkOut()
    {
        $user = auth()->user();
        $today = Carbon::today();
        $attendance = Attendance::where('employee_id', $user->id)->whereDate('date', $today)->first();
        
        if (!$attendance || !$attendance->check_in) {
            return back()->with('error', 'You must check in first');
        }
        
        if ($attendance->check_out) {
            return back()->with('error', 'You already checked out today');
        }
        
        $attendance->check_out = Carbon::now();
        $attendance->save();
        $attendance->calculateHoursWorked();
        
        return redirect()->route('dashboard')->with('success', 'Checked out successfully at ' . Carbon::now()->format('H:i:s') . ' - Hours worked: ' . $attendance->hours_worked);
    }

    /**
     * Display attendance report.
     */
    public function report(Request $request)
    {
        if (Gate::denies('viewAny', Attendance::class)) {
            abort(403);
        }
        
        $user = auth()->user();
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);
        
        if ($user->isAdmin()) {
            $attendances = Attendance::with('employee')->whereYear('date', $year)->whereMonth('date', $month)->get();
        } elseif ($user->isManager()) {
            $employeeIds = User::where('department_id', $user->department_id)->where('role_id', User::ROLE_EMPLOYEE)->pluck('id');
            $attendances = Attendance::with('employee')->whereIn('employee_id', $employeeIds)->whereYear('date', $year)->whereMonth('date', $month)->get();
        } else {
            $attendances = Attendance::where('employee_id', $user->id)->whereYear('date', $year)->whereMonth('date', $month)->get();
        }
        
        $stats = $this->calculateStats($attendances);
        $months = $this->getMonthsList();
        $years = range(2020, Carbon::now()->year);
        
        return view('attendances.report', compact('attendances', 'stats', 'month', 'year', 'months', 'years'));
    }

    /**
     * Export attendance to CSV.
     */
    public function export(Request $request)
    {
        if (Gate::denies('viewAny', Attendance::class)) {
            abort(403);
        }
        
        $user = auth()->user();
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);
        
        if ($user->isAdmin()) {
            $attendances = Attendance::with('employee')->whereYear('date', $year)->whereMonth('date', $month)->get();
        } elseif ($user->isManager()) {
            $employeeIds = User::where('department_id', $user->department_id)->where('role_id', User::ROLE_EMPLOYEE)->pluck('id');
            $attendances = Attendance::with('employee')->whereIn('employee_id', $employeeIds)->whereYear('date', $year)->whereMonth('date', $month)->get();
        } else {
            $attendances = Attendance::where('employee_id', $user->id)->whereYear('date', $year)->whereMonth('date', $month)->get();
        }
        
        $filename = "attendances_{$year}_{$month}.csv";
        $handle = fopen('php://temp', 'w');
        
        fputcsv($handle, ['Employee', 'Date', 'Check In', 'Check Out', 'Hours Worked', 'Status']);
        
        foreach ($attendances as $attendance) {
            fputcsv($handle, [
                $attendance->employee->first_name . ' ' . $attendance->employee->last_name,
                $attendance->date->format('d/m/Y'),
                $attendance->getCheckInFormatted(),
                $attendance->getCheckOutFormatted(),
                $attendance->hours_worked ?? 0,
                $attendance->status
            ]);
        }
        
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);
        
        return response($csv, 200)->header('Content-Type', 'text/csv')->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }

    /**
     * Get employees list based on user role.
     */
    private function getEmployeesList()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return User::where('role_id', User::ROLE_EMPLOYEE)->get();
        } elseif ($user->isManager()) {
            return User::where('department_id', $user->department_id)->where('role_id', User::ROLE_EMPLOYEE)->get();
        }
        
        return collect([$user]);
    }

    /**
     * Calculate statistics from attendances.
     */
    private function calculateStats($attendances)
    {
        $total = $attendances->count();
        $present = $attendances->where('status', 'present')->count();
        $absent = $attendances->where('status', 'absent')->count();
        $late = $attendances->where('status', 'late')->count();
        $halfDay = $attendances->where('status', 'half-day')->count();
        $totalHours = $attendances->sum('hours_worked');
        
        return [
            'total' => $total,
            'present' => $present,
            'absent' => $absent,
            'late' => $late,
            'half_day' => $halfDay,
            'present_rate' => $total > 0 ? round(($present / $total) * 100, 2) : 0,
            'absent_rate' => $total > 0 ? round(($absent / $total) * 100, 2) : 0,
            'total_hours' => round($totalHours, 2),
            'average_hours' => $total > 0 ? round($totalHours / $total, 2) : 0
        ];
    }

    /**
     * Get months list.
     */
    private function getMonthsList()
    {
        return [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];
    }
}
