@extends('layouts.app')

@section('title', 'Attendance')

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
        transform: translateY(-1px);
    }
    
    .btn-info-custom {
        background: #10B981;
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
    
    .btn-info-custom:hover {
        background: #059669;
        color: white;
    }
    
    .filter-form {
        display: inline-flex;
        gap: 10px;
        align-items: center;
    }
    
    .filter-input {
        padding: 8px 12px;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        font-family: 'Roboto', sans-serif;
        font-size: 0.85rem;
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
    
    .badge-success {
        background: #10B981;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-danger {
        background: #EF4444;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-warning {
        background: #F59E0B;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-info {
        background: #3B82F6;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .btn-action {
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 0.8rem;
        margin: 0 2px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none;
    }
    
    .btn-action-info {
        background: #F3F4F6;
        color: #1D4ED8;
    }
    
    .btn-action-warning {
        background: #F3F4F6;
        color: #F59E0B;
    }
    
    .btn-action-danger {
        background: #F3F4F6;
        color: #EF4444;
    }
    
    .btn-action:hover {
        transform: translateY(-1px);
    }
    
    .card-body-custom {
        padding: 24px;
    }
</style>

<div class="container-fluid">
    <div class="main-card">
        <div class="card-header-custom">
            <h3>
                <i class="fas fa-calendar-check"></i> Attendance Records
            </h3>
            <div>
                <form method="GET" action="{{ route('attendances.index') }}" class="filter-form">
                    <input type="date" name="date" value="{{ $date }}" class="filter-input">
                    <button type="submit" class="btn-primary-custom">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </form>
                @can('create', App\Models\Attendance::class)
                <a href="{{ route('attendances.create') }}" class="btn-primary-custom ms-2">
                    <i class="fas fa-plus"></i> Add Attendance
                </a>
                @endcan
                <a href="{{ route('attendances.report') }}" class="btn-info-custom ms-2">
                    <i class="fas fa-chart-line"></i> Report
                </a>
            </div>
        </div>
        <div class="card-body-custom">
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Date</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Hours Worked</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                        <tr>
                            <td>
                                <a href="{{ route('employees.show', $attendance->employee_id) }}" style="color: #1D4ED8; text-decoration: none;">
                                    {{ $attendance->employee->getFullName() }}
                                </a>
                            </td>
                            <td>{{ $attendance->date->format('d/m/Y') }}</td>
                            <td>{{ $attendance->getCheckInFormatted() }}</td>
                            <td>{{ $attendance->getCheckOutFormatted() }}</td>
                            <td>{{ $attendance->hours_worked ?? 0 }} hrs</td>
                            <td>
                                @if($attendance->status == 'present')
                                    <span class="badge-success">Present</span>
                                @elseif($attendance->status == 'absent')
                                    <span class="badge-danger">Absent</span>
                                @elseif($attendance->status == 'late')
                                    <span class="badge-warning">Late</span>
                                @else
                                    <span class="badge-info">Half Day</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('attendances.show', $attendance) }}" class="btn-action btn-action-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @can('update', $attendance)
                                <a href="{{ route('attendances.edit', $attendance) }}" class="btn-action btn-action-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                @can('delete', $attendance)
                                <form method="POST" action="{{ route('attendances.destroy', $attendance) }}" class="d-inline" 
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-action-danger" style="border: none; cursor: pointer;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 20px;">
                {{ $attendances->links() }}
            </div>
        </div>
    </div>
</div>
@endsection