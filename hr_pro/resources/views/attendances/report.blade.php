@extends('layouts.app')

@section('title', 'Attendance Report')

@section('content')
<style>
    .main-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
    }
    
    .card-header-custom {
        padding: 20px 24px;
        border-bottom: 1px solid #E5E7EB;
        background: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .card-header-custom h3 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 1.25rem;
        color: #1F2937;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .card-header-custom h3 i {
        color: #1D4ED8;
    }
    
    .btn-primary-custom {
        background: #1D4ED8;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-primary-custom:hover {
        background: #1E3A8A;
        color: white;
    }
    
    .btn-secondary-custom {
        background: #F3F4F6;
        color: #374151;
        border: none;
        padding: 8px 16px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-secondary-custom:hover {
        background: #E5E7EB;
        color: #1F2937;
    }
    
    .stat-card {
        border-radius: 16px;
        padding: 20px;
        text-align: center;
        transition: transform 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
    }
    
    .stat-card h5 {
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 10px;
    }
    
    .stat-card h3 {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 2rem;
        margin: 10px 0;
    }
    
    .stat-card small {
        font-family: 'Roboto', sans-serif;
        font-size: 0.75rem;
    }
    
    .bg-primary-custom {
        background: linear-gradient(135deg, #1D4ED8, #1E3A8A);
        color: white;
    }
    
    .bg-success-custom {
        background: linear-gradient(135deg, #10B981, #059669);
        color: white;
    }
    
    .bg-danger-custom {
        background: linear-gradient(135deg, #EF4444, #DC2626);
        color: white;
    }
    
    .bg-info-custom {
        background: linear-gradient(135deg, #3B82F6, #2563EB);
        color: white;
    }
    
    .table-custom {
        width: 100%;
        font-family: 'Roboto', sans-serif;
    }
    
    .table-custom thead {
        background: #F3F4F6;
    }
    
    .table-custom th {
        padding: 12px 16px;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        color: #374151;
        border-bottom: 1px solid #E5E7EB;
    }
    
    .table-custom td {
        padding: 12px 16px;
        border-bottom: 1px solid #E5E7EB;
        color: #4B5563;
    }
    
    .progress-custom {
        background: #F3F4F6;
        border-radius: 10px;
        overflow: hidden;
        height: 20px;
    }
    
    .progress-bar-custom {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .card-body-custom {
        padding: 24px;
    }
    
    .text-success {
        color: #10B981 !important;
        font-weight: 600;
    }
    
    .text-danger {
        color: #EF4444 !important;
        font-weight: 600;
    }
    
    .text-warning {
        color: #F59E0B !important;
        font-weight: 600;
    }
    
    .text-info {
        color: #3B82F6 !important;
        font-weight: 600;
    }
</style>

<div class="container-fluid">
    <div class="main-card">
        <div class="card-header-custom">
            <h3>
                <i class="fas fa-chart-bar"></i> Attendance Report
            </h3>
            <div>
                <form method="GET" action="{{ route('attendances.report') }}" class="d-inline">
                    <div class="d-inline-flex gap-2">
                        <select name="month" class="filter-input" style="padding: 8px 12px; border: 1px solid #E5E7EB; border-radius: 10px;">
                            @foreach($months as $key => $monthName)
                            <option value="{{ $key }}" {{ $month == $key ? 'selected' : '' }}>
                                {{ $monthName }}
                            </option>
                            @endforeach
                        </select>
                        <select name="year" class="filter-input" style="padding: 8px 12px; border: 1px solid #E5E7EB; border-radius: 10px;">
                            @foreach($years as $yearOption)
                            <option value="{{ $yearOption }}" {{ $year == $yearOption ? 'selected' : '' }}>
                                {{ $yearOption }}
                            </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn-primary-custom">
                            <i class="fas fa-chart-line"></i> Generate
                        </button>
                    </div>
                </form>
                <a href="{{ route('attendances.index') }}" class="btn-secondary-custom ms-2">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
        <div class="card-body-custom">
            <div class="row mb-4" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <div class="stat-card bg-primary-custom">
                    <h5>Total Days</h5>
                    <h3>{{ $stats['total'] }}</h3>
                </div>
                <div class="stat-card bg-success-custom">
                    <h5>Present</h5>
                    <h3>{{ $stats['present'] }}</h3>
                    <small>{{ $stats['present_rate'] }}%</small>
                </div>
                <div class="stat-card bg-danger-custom">
                    <h5>Absent</h5>
                    <h3>{{ $stats['absent'] }}</h3>
                    <small>{{ $stats['absent_rate'] }}%</small>
                </div>
                <div class="stat-card bg-info-custom">
                    <h5>Total Hours</h5>
                    <h3>{{ $stats['total_hours'] }}</h3>
                    <small>Avg: {{ $stats['average_hours'] }} hrs/day</small>
                </div>
            </div>

            <!-- Attendance Table -->
            <div class="table-responsive">
                <table class="table-custom">
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
                            <td style="width: 150px;">
                                <div class="progress-custom">
                                    <div class="progress-bar-custom" style="width: {{ $rate }}%; background: {{ $rate >= 90 ? '#10B981' : ($rate >= 75 ? '#F59E0B' : '#EF4444') }}">
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
@endsection