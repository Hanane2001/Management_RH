@extends('layouts.app')

@section('title', 'Leave Request Details')

@section('content')
<style>
    .details-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
        max-width: 700px;
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
    
    .info-section {
        background: #F9FAFB;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .info-section h4 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 1rem;
        color: #1F2937;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid #E5E7EB;
    }
    
    .info-row {
        display: flex;
        margin-bottom: 12px;
    }
    
    .info-label {
        width: 130px;
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        font-weight: 500;
        color: #6B7280;
    }
    
    .info-value {
        flex: 1;
        font-family: 'Roboto', sans-serif;
        font-size: 0.85rem;
        color: #374151;
    }
    
    .info-value strong {
        font-weight: 600;
        color: #1F2937;
    }
    
    .badge-pending {
        background: #FEF3C7;
        color: #D97706;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-block;
    }
    
    .badge-approved {
        background: #D1FAE5;
        color: #065F46;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-block;
    }
    
    .badge-rejected {
        background: #FEE2E2;
        color: #991B1B;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-block;
    }
    
    .badge-type {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .badge-paid {
        background: #EFF6FF;
        color: #1D4ED8;
    }
    
    .badge-sick {
        background: #FEF3C7;
        color: #D97706;
    }
    
    .badge-unpaid {
        background: #FEE2E2;
        color: #DC2626;
    }
    
    .badge-exceptional {
        background: #F3E8FF;
        color: #7E22CE;
    }
    
    .action-buttons {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #E5E7EB;
    }
    
    .btn-approve {
        background: #10B981;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    
    .btn-approve:hover {
        background: #059669;
    }
    
    .btn-reject {
        background: #EF4444;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    
    .btn-reject:hover {
        background: #DC2626;
    }
    
    .reason-box {
        background: #F9FAFB;
        border-radius: 12px;
        padding: 16px;
        margin-top: 10px;
        font-family: 'Roboto', sans-serif;
        font-size: 0.85rem;
        color: #374151;
        line-height: 1.5;
    }
    
    @media (max-width: 768px) {
        .card-header-custom {
            padding: 16px 20px;
        }
        
        .card-body-custom {
            padding: 20px;
        }
        
        .info-row {
            flex-direction: column;
        }
        
        .info-label {
            width: 100%;
            margin-bottom: 4px;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-approve, .btn-reject {
            justify-content: center;
        }
    }
</style>

<div class="container-fluid">
    <div class="details-card">
        <div class="card-header-custom">
            <h3>
                <i class="fas fa-calendar-alt"></i> Leave Request Details
            </h3>
            <a href="{{ route('leaves.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="card-body-custom">
            <div class="info-section">
                <h4><i class="fas fa-user"></i> Employee Information</h4>
                <div class="info-row">
                    <div class="info-label">Employee Name</div>
                    <div class="info-value"><strong>{{ $leave->employee->getFullName() }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Department</div>
                    <div class="info-value">{{ $leave->employee->department->name ?? 'Not assigned' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $leave->employee->email }}</div>
                </div>
            </div>

            <div class="info-section">
                <h4><i class="fas fa-info-circle"></i> Leave Details</h4>
                <div class="info-row">
                    <div class="info-label">Leave Type</div>
                    <div class="info-value">
                        <span class="badge-type 
                            @if($leave->type == 'paid') badge-paid
                            @elseif($leave->type == 'sick') badge-sick
                            @elseif($leave->type == 'unpaid') badge-unpaid
                            @else badge-exceptional @endif">
                            {{ ucfirst($leave->type) }}
                        </span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Start Date</div>
                    <div class="info-value">{{ $leave->start_date->format('l, d F Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">End Date</div>
                    <div class="info-value">{{ $leave->end_date->format('l, d F Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Duration</div>
                    <div class="info-value">{{ $leave->duration }} day(s)</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        @if($leave->status == 'pending')
                            <span class="badge-pending"><i class="fas fa-clock"></i> Pending Approval</span>
                        @elseif($leave->status == 'approved')
                            <span class="badge-approved"><i class="fas fa-check-circle"></i> Approved</span>
                        @else
                            <span class="badge-rejected"><i class="fas fa-times-circle"></i> Rejected</span>
                        @endif
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Request Date</div>
                    <div class="info-value">{{ $leave->request_date->format('l, d F Y') }}</div>
                </div>
                @if($leave->processed_date)
                <div class="info-row">
                    <div class="info-label">Processed Date</div>
                    <div class="info-value">{{ $leave->processed_date->format('l, d F Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Processed By</div>
                    <div class="info-value">{{ $leave->processedBy ? $leave->processedBy->getFullName() : 'System' }}</div>
                </div>
                @endif
            </div>
            
            @if($leave->reason)
            <div class="info-section">
                <h4><i class="fas fa-comment"></i> Reason</h4>
                <div class="reason-box">
                    {{ $leave->reason }}
                </div>
            </div>
            @endif
            
            @can('process', $leave)
            @if($leave->isPending())
            <div class="action-buttons">
                <form method="POST" action="{{ route('leaves.approve', $leave) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn-approve">
                        <i class="fas fa-check"></i> Approve Leave
                    </button>
                </form>
                <form method="POST" action="{{ route('leaves.reject', $leave) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn-reject">
                        <i class="fas fa-times"></i> Reject Leave
                    </button>
                </form>
            </div>
            @endif
            @endcan
        </div>
    </div>
</div>
@endsection