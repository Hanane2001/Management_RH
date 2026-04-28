@extends('layouts.app')

@section('title', 'Attendance Details')

@section('content')
<style>
    .detail-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
        max-width: 700px;
        margin: 0 auto;
    }
    
    .detail-header {
        padding: 20px 24px;
        border-bottom: 1px solid #E5E7EB;
        background: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .detail-header h3 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 1.25rem;
        color: #1F2937;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .detail-header h3 i {
        color: #1D4ED8;
    }
    
    .btn-back {
        background: #F3F4F6;
        color: #374151;
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
    
    .btn-back:hover {
        background: #E5E7EB;
        color: #1F2937;
    }
    
    .detail-body {
        padding: 24px;
    }
    
    .detail-table {
        width: 100%;
        font-family: 'Roboto', sans-serif;
    }
    
    .detail-table th {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        color: #374151;
        padding: 12px;
        background: #F3F4F6;
        width: 40%;
        border-radius: 10px 0 0 10px;
    }
    
    .detail-table td {
        font-family: 'Roboto', sans-serif;
        font-size: 0.9rem;
        color: #4B5563;
        padding: 12px;
        background: white;
        border-bottom: 1px solid #E5E7EB;
    }
    
    .badge-success {
        background: #10B981;
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-block;
    }
    
    .badge-danger {
        background: #EF4444;
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-block;
    }
    
    .badge-warning {
        background: #F59E0B;
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-block;
    }
    
    .badge-info {
        background: #3B82F6;
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-block;
    }
    
    .btn-warning-custom {
        background: #F59E0B;
        color: white;
        border: none;
        padding: 10px 20px;
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
    
    .btn-warning-custom:hover {
        background: #D97706;
        color: white;
        transform: translateY(-1px);
    }
    
    .btn-danger-custom {
        background: #EF4444;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }
    
    .btn-danger-custom:hover {
        background: #DC2626;
        transform: translateY(-1px);
    }
</style>

<div class="container-fluid">
    <div class="detail-card">
        <div class="detail-header">
            <h3>
                <i class="fas fa-info-circle"></i> Attendance Details
            </h3>
            <a href="{{ route('attendances.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="detail-body">
            <table class="detail-table">
                <tr>
                    <th>Employee</th>
                    <td><strong>{{ $attendance->employee->getFullName() }}</strong></td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>{{ $attendance->date->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Check In Time</th>
                    <td>{{ $attendance->getCheckInFormatted() }}</td>
                </tr>
                <tr>
                    <th>Check Out Time</th>
                    <td>{{ $attendance->getCheckOutFormatted() }}</td>
                </tr>
                <tr>
                    <th>Hours Worked</th>
                    <td><strong style="color: #1D4ED8; font-size: 1.1rem;">{{ $attendance->hours_worked ?? 0 }} hours</strong></td>
                </tr>
                <tr>
                    <th>Status</th>
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
                </tr>
                <tr>
                    <th>Late Check In</th>
                    <td>
                        @if($attendance->isLate())
                            <span style="color: #EF4444; font-weight: 600;">Yes</span>
                        @else
                            <span style="color: #10B981; font-weight: 600;">No</span>
                        @endif
                    </td>
                </tr>
             </table>
            
            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 24px;">
                @can('update', $attendance)
                <a href="{{ route('attendances.edit', $attendance) }}" class="btn-warning-custom">
                    <i class="fas fa-edit"></i> Edit
                </a>
                @endcan
                @can('delete', $attendance)
                <form method="POST" action="{{ route('attendances.destroy', $attendance) }}" class="d-inline" 
                      onsubmit="return confirm('Are you sure you want to delete this attendance record?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger-custom">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection