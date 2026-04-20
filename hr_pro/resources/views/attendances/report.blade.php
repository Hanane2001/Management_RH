@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Attendance Report</h1>
    
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('attendances.report') }}" class="row">
                <div class="col-md-4">
                    <label>Month</label>
                    <select name="month" class="form-control">
                        @foreach($months as $key => $monthName)
                            <option value="{{ $key }}" {{ $month == $key ? 'selected' : '' }}>
                                {{ $monthName }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Year</label>
                    <select name="year" class="form-control">
                        @foreach($years as $yearValue)
                            <option value="{{ $yearValue }}" {{ $year == $yearValue ? 'selected' : '' }}>
                                {{ $yearValue }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary form-control">Generate Report</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h5>Total Days</h5>
                    <h2>{{ $stats['total'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h5>Present</h5>
                    <h2>{{ $stats['present'] }}</h2>
                    <small>{{ $stats['present_rate'] }}%</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h5>Absent</h5>
                    <h2>{{ $stats['absent'] }}</h2>
                    <small>{{ $stats['absent_rate'] }}%</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h5>Total Hours</h5>
                    <h2>{{ $stats['total_hours'] }}</h2>
                    <small>Avg: {{ $stats['average_hours'] }}h</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-warning">Late Arrivals</div>
                <div class="card-body text-center">
                    <h3>{{ $stats['late'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info">Half Days</div>
                <div class="card-body text-center">
                    <h3>{{ $stats['half_day'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-secondary text-white">Attendance Rate</div>
                <div class="card-body text-center">
                    <h3>{{ $stats['present_rate'] }}%</h3>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: {{ $stats['present_rate'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-header">Detailed Records</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Employee</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Hours</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->date->format('d/m/Y') }}</td>
                            <td>{{ $attendance->employee->first_name }} {{ $attendance->employee->last_name }}</td>
                            <td>{{ $attendance->getCheckInFormatted() }}</td>
                            <td>{{ $attendance->getCheckOutFormatted() }}</td>
                            <td>{{ $attendance->hours_worked ?? '-' }}</td>
                            <td>{!! $attendance->getStatusBadge() !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection