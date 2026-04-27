@extends('layouts.app')

@section('title', 'Attendance Report')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Attendance Report</h3>
                    <div class="float-end">
                        <form method="GET" action="{{ route('attendances.report') }}" class="d-inline">
                            <div class="input-group">
                                <select name="month" class="form-control" style="width: auto;">
                                    @foreach($months as $key => $monthName)
                                    <option value="{{ $key }}" {{ $month == $key ? 'selected' : '' }}>
                                        {{ $monthName }}
                                    </option>
                                    @endforeach
                                </select>
                                <select name="year" class="form-control" style="width: auto;">
                                    @foreach($years as $yearOption)
                                    <option value="{{ $yearOption }}" {{ $year == $yearOption ? 'selected' : '' }}>
                                        {{ $yearOption }}
                                    </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary">Generate</button>
                            </div>
                        </form>
                        <a href="{{ route('attendances.index') }}" class="btn btn-secondary ms-2">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h5>Total Days</h5>
                                    <h3>{{ $stats['total'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h5>Present</h5>
                                    <h3>{{ $stats['present'] }}</h3>
                                    <small>{{ $stats['present_rate'] }}%</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body text-center">
                                    <h5>Absent</h5>
                                    <h3>{{ $stats['absent'] }}</h3>
                                    <small>{{ $stats['absent_rate'] }}%</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h5>Total Hours</h5>
                                    <h3>{{ $stats['total_hours'] }}</h3>
                                    <small>Avg: {{ $stats['average_hours'] }} hrs/day</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Department</th>
                                    <th>Present</th>
                                    <th>Absent</th>
                                    <th>Late</th>
                                    <th>Half Day</th>
                                    <th>Total Hours</th>
                                    <th>Attendance Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $grouped = $attendances->groupBy('employee_id');
                                @endphp
                                @foreach($grouped as $employeeId => $employeeAttendances)
                                @php
                                    $employee = $employeeAttendances->first()->employee;
                                    $present = $employeeAttendances->where('status', 'present')->count();
                                    $absent = $employeeAttendances->where('status', 'absent')->count();
                                    $late = $employeeAttendances->where('status', 'late')->count();
                                    $halfDay = $employeeAttendances->where('status', 'half-day')->count();
                                    $totalHours = $employeeAttendances->sum('hours_worked');
                                    $rate = $employeeAttendances->count() > 0 ? round(($present / $employeeAttendances->count()) * 100, 2) : 0;
                                @endphp
                                <tr>
                                    <td>{{ $employee->getFullName() }}</td>
                                    <td>{{ $employee->department->name ?? 'N/A' }}</td>
                                    <td class="text-success">{{ $present }}</td>
                                    <td class="text-danger">{{ $absent }}</td>
                                    <td class="text-warning">{{ $late }}</td>
                                    <td class="text-info">{{ $halfDay }}</td>
                                    <td>{{ number_format($totalHours, 2) }}</td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-{{ $rate >= 90 ? 'success' : ($rate >= 75 ? 'warning' : 'danger') }}" 
                                                 style="width: {{ $rate }}%">
                                                {{ $rate }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection