@extends('layouts.app')

@section('title', 'Leave Balance Details')

@section('content')
<style>
    .details-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
        max-width: 600px;
        margin: 0 auto;
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
    
    .card-body-custom {
        padding: 24px;
    }
    
    .info-table {
        width: 100%;
        font-family: 'Roboto', sans-serif;
    }
    
    .info-table tr td {
        padding: 12px 0;
        border-bottom: 1px solid #F3F4F6;
    }
    
    .info-table tr td:first-child {
        width: 140px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        color: #6B7280;
        font-size: 0.85rem;
    }
    
    .info-table tr td:last-child {
        color: #374151;
        font-size: 0.9rem;
    }
    
    .info-table tr:last-child td {
        border-bottom: none;
    }
    
    .progress-large {
        height: 30px;
        background: #E5E7EB;
        border-radius: 15px;
        overflow: hidden;
        margin: 15px 0;
    }
    
    .progress-bar-large {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 500;
        color: white;
        transition: width 0.3s ease;
    }
    
    .badge-critical {
        display: inline-block;
        padding: 4px 12px;
        background: #FEE2E2;
        color: #DC2626;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .badge-low {
        display: inline-block;
        padding: 4px 12px;
        background: #FEF3C7;
        color: #D97706;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .badge-good {
        display: inline-block;
        padding: 4px 12px;
        background: #D1FAE5;
        color: #065F46;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .action-buttons {
        display: flex;
        gap: 12px;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #E5E7EB;
        justify-content: flex-end;
    }
    
    .btn-warning, .btn-success, .btn-danger {
        padding: 8px 20px;
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
    
    .btn-warning {
        background: #FEF3C7;
        color: #D97706;
    }
    
    .btn-warning:hover {
        background: #FDE68A;
    }
    
    .btn-success {
        background: #D1FAE5;
        color: #059669;
    }
    
    .btn-success:hover {
        background: #A7F3D0;
    }
    
    .btn-danger {
        background: #FEE2E2;
        color: #DC2626;
    }
    
    .btn-danger:hover {
        background: #FECACA;
    }
    
    @media (max-width: 768px) {
        .card-header-custom {
            padding: 16px 20px;
        }
        
        .card-body-custom {
            padding: 20px;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-warning, .btn-success, .btn-danger {
            justify-content: center;
        }
    }
</style>

<div class="container-fluid">
    <div class="details-card">
        <div class="card-header-custom">
            <h3>
                <i class="fas fa-calendar-alt"></i> Leave Balance Details
            </h3>
            <a href="{{ route('leave-balances.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="card-body-custom">
            <table class="info-table">
                <tr>
                    <td>Employee</td>
                    <td><strong>{{ $leaveBalance->employee->getFullName() }}</strong></td>
                </tr>
                <tr>
                    <td>Year</td>
                    <td>{{ $leaveBalance->year }}</td>
                </tr>
                <tr>
                    <td>Total Days</td>
                    <td>{{ $leaveBalance->total_days }} days</td>
                </tr>
                <tr>
                    <td>Used Days</td>
                    <td>{{ $leaveBalance->used_days }} days</td>
                </tr>
                <tr>
                    <td>Remaining Days</td>
                    <td>
                        @php
                            $remaining = $leaveBalance->remaining_days;
                            $remainingClass = $remaining < 5 ? 'badge-critical' : ($remaining < 10 ? 'badge-low' : 'badge-good');
                        @endphp
                        <span class="{{ $remainingClass }}">{{ $remaining }} days</span>
                    </td>
                </tr>
                <tr>
                    <td>Usage Rate</td>
                    <td>
                        @php $percentage = $leaveBalance->getUsedPercentage(); @endphp
                        <div class="progress-large">
                            <div class="progress-bar-large 
                                @if($percentage > 80) progress-bar-danger
                                @elseif($percentage > 50) progress-bar-warning
                                @else progress-bar-success @endif" 
                                style="width: {{ $percentage }}%; background: 
                                    @if($percentage > 80) #EF4444
                                    @elseif($percentage > 50) #F59E0B
                                    @else #10B981 @endif">
                                {{ number_format($percentage, 1) }}%
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            
            <div class="action-buttons">
                @can('update', $leaveBalance)
                <a href="{{ route('leave-balances.edit', $leaveBalance) }}" class="btn-warning">
                    <i class="fas fa-edit"></i> Edit Balance
                </a>
                @endcan
                @can('addDays', $leaveBalance)
                <button type="button" class="btn-success" data-bs-toggle="modal" data-bs-target="#addDaysModal">
                    <i class="fas fa-plus-circle"></i> Add Days
                </button>
                @endcan
                @can('delete', $leaveBalance)
                <form method="POST" action="{{ route('leave-balances.destroy', $leaveBalance) }}" class="d-inline" 
                      onsubmit="return confirm('Are you sure? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger">
                        <i class="fas fa-trash"></i> Delete Balance
                    </button>
                </form>
                @endcan
            </div>
        </div>
    </div>
</div>

@can('addDays', $leaveBalance)
<div class="modal fade" id="addDaysModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header" style="border-bottom: 1px solid #E5E7EB; padding: 20px;">
                <h5 class="modal-title" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                    <i class="fas fa-plus-circle" style="color: #10B981;"></i> Add Days to Balance
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('leave-balances.add-days', $leaveBalance) }}">
                @csrf
                <div class="modal-body" style="padding: 20px;">
                    <div class="form-group">
                        <label class="form-label" style="font-family: 'Inter', sans-serif; font-weight: 500;">Number of Days to Add</label>
                        <input type="number" class="form-input" name="days" min="1" required style="width: 100%; padding: 10px; border: 1px solid #E5E7EB; border-radius: 10px;">
                        <small class="text-muted" style="font-family: 'Roboto', sans-serif; display: block; margin-top: 8px;">
                            Current remaining: {{ $leaveBalance->remaining_days }} days
                        </small>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #E5E7EB; padding: 20px; gap: 10px;">
                    <button type="button" class="btn-back" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary" style="padding: 8px 20px;">Add Days</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
@endsection