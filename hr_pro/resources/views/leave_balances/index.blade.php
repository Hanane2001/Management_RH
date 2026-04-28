@extends('layouts.app')

@section('title', 'Leave Balances')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .page-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 1.5rem;
        color: #1F2937;
        margin: 0;
    }
    
    .btn-group-header {
        display: flex;
        gap: 10px;
    }
    
    .btn-primary, .btn-info {
        padding: 8px 16px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    
    .btn-primary {
        background: #1D4ED8;
        color: white;
    }
    
    .btn-primary:hover {
        background: #1E3A8A;
    }
    
    .btn-info {
        background: #3B82F6;
        color: white;
    }
    
    .btn-info:hover {
        background: #2563EB;
    }
    
    .data-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
    }
    
    .table-container {
        overflow-x: auto;
    }
    
    .table-modern {
        width: 100%;
        font-family: 'Roboto', sans-serif;
        border-collapse: collapse;
    }
    
    .table-modern thead th {
        background: #F9FAFB;
        padding: 14px 16px;
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #E5E7EB;
        text-align: left;
    }
    
    .table-modern tbody td {
        padding: 14px 16px;
        font-size: 0.85rem;
        color: #374151;
        border-bottom: 1px solid #F3F4F6;
    }
    
    .table-modern tbody tr:hover td {
        background: #F9FAFB;
    }
    
    .progress-custom {
        height: 8px;
        background: #E5E7EB;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 5px;
    }
    
    .progress-bar-custom {
        height: 100%;
        border-radius: 10px;
        transition: width 0.3s ease;
    }
    
    .progress-bar-success {
        background: #10B981;
    }
    
    .progress-bar-warning {
        background: #F59E0B;
    }
    
    .progress-bar-danger {
        background: #EF4444;
    }
    
    .progress-label {
        font-size: 0.7rem;
        color: #6B7280;
    }
    
    .employee-link {
        color: #1D4ED8;
        text-decoration: none;
        font-weight: 500;
    }
    
    .employee-link:hover {
        text-decoration: underline;
    }
    
    .badge-critical {
        display: inline-block;
        padding: 4px 10px;
        background: #FEE2E2;
        color: #DC2626;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .badge-low {
        display: inline-block;
        padding: 4px 10px;
        background: #FEF3C7;
        color: #D97706;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .badge-good {
        display: inline-block;
        padding: 4px 10px;
        background: #D1FAE5;
        color: #065F46;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .action-buttons {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }
    
    .btn-action {
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 0.75rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    
    .btn-view {
        background: #EFF6FF;
        color: #1D4ED8;
    }
    
    .btn-view:hover {
        background: #DBEAFE;
    }
    
    .btn-edit {
        background: #FEF3C7;
        color: #D97706;
    }
    
    .btn-edit:hover {
        background: #FDE68A;
    }
    
    .btn-add-days {
        background: #D1FAE5;
        color: #059669;
    }
    
    .btn-add-days:hover {
        background: #A7F3D0;
    }
    
    .pagination-container {
        padding: 20px;
        border-top: 1px solid #E5E7EB;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #9CA3AF;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 15px;
        display: block;
    }
    
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .btn-group-header {
            width: 100%;
        }
        
        .btn-primary, .btn-info {
            flex: 1;
            justify-content: center;
        }
        
        .table-modern thead th,
        .table-modern tbody td {
            padding: 10px 12px;
        }
    }
</style>

<div class="container-fluid">
    <div class="page-header">
        <h1 class="page-title">Leave Balances</h1>
        <div class="btn-group-header">
            @can('create', App\Models\LeaveBalance::class)
            <form method="POST" action="{{ route('leave-balances.initialize') }}" class="d-inline" 
                  onsubmit="return confirm('Initialize leave balances for the current year? This will create balances for all employees without existing balances.')">
                @csrf
                <button type="submit" class="btn-info">
                    <i class="fas fa-sync-alt"></i> Initialize Year
                </button>
            </form>
            <a href="{{ route('leave-balances.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Add Balance
            </a>
            @endcan
        </div>
    </div>
    
    <div class="data-card">
        <div class="table-container">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Year</th>
                        <th>Total Days</th>
                        <th>Used Days</th>
                        <th>Remaining</th>
                        <th>Usage</th>
                        <th style="width: 130px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($balances as $balance)
                    <tr>
                        <td>
                            <a href="{{ route('employees.show', $balance->employee_id) }}" class="employee-link">
                                {{ $balance->employee->getFullName() }}
                            </a>
                        </td>
                        <td>{{ $balance->year }}</a>
                        <td>{{ $balance->total_days }}</a>
                        <td>{{ $balance->used_days }}</a>
                        <td>
                            @php
                                $remainingClass = $balance->remaining_days < 5 ? 'badge-critical' : ($balance->remaining_days < 10 ? 'badge-low' : 'badge-good');
                            @endphp
                            <span class="{{ $remainingClass }}">{{ $balance->remaining_days }} days</span>
                        </td>
                        <td>
                            <div class="progress-custom">
                                @php $percentage = $balance->getUsedPercentage(); @endphp
                                <div class="progress-bar-custom 
                                    @if($percentage > 80) progress-bar-danger
                                    @elseif($percentage > 50) progress-bar-warning
                                    @else progress-bar-success @endif" 
                                    style="width: {{ $percentage }}%">
                                </div>
                            </div>
                            <div class="progress-label">{{ number_format($percentage, 1) }}% used</div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('leave-balances.show', $balance) }}" class="btn-action btn-view" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @can('update', $balance)
                                <a href="{{ route('leave-balances.edit', $balance) }}" class="btn-action btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                @can('addDays', $balance)
                                <button type="button" class="btn-action btn-add-days" title="Add Days" data-bs-toggle="modal" data-bs-target="#addDaysModal{{ $balance->id }}">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            <i class="fas fa-calendar-alt"></i>
                            No leave balances found
                        </a>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($balances->hasPages())
        <div class="pagination-container">
            {{ $balances->links() }}
        </div>
        @endif
    </div>
</div>

@foreach($balances as $balance)
@can('addDays', $balance)
<div class="modal fade" id="addDaysModal{{ $balance->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header" style="border-bottom: 1px solid #E5E7EB; padding: 20px;">
                <h5 class="modal-title" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                    <i class="fas fa-plus-circle" style="color: #10B981;"></i> Add Days to Balance
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('leave-balances.add-days', $balance) }}">
                @csrf
                <div class="modal-body" style="padding: 20px;">
                    <div class="form-group">
                        <label class="form-label" style="font-family: 'Inter', sans-serif; font-weight: 500;">Number of Days to Add</label>
                        <input type="number" class="form-input" name="days" min="1" required style="width: 100%; padding: 10px; border: 1px solid #E5E7EB; border-radius: 10px;">
                        <small class="text-muted" style="font-family: 'Roboto', sans-serif; display: block; margin-top: 8px;">
                            Current remaining: {{ $balance->remaining_days }} days
                        </small>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #E5E7EB; padding: 20px; gap: 10px;">
                    <button type="button" class="btn-back" data-bs-dismiss="modal" style="background: #F3F4F6; color: #374151; padding: 8px 20px; border-radius: 10px; border: none;">Cancel</button>
                    <button type="submit" class="btn-primary" style="padding: 8px 20px;">Add Days</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
@endforeach
@endsection