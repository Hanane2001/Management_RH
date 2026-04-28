@extends('layouts.app')

@section('title', 'Leave Requests')

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
    
    .btn-add {
        background: #1D4ED8;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    
    .btn-add:hover {
        background: #1E3A8A;
        color: white;
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
    
    .badge-pending {
        display: inline-block;
        padding: 4px 10px;
        background: #FEF3C7;
        color: #D97706;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .badge-approved {
        display: inline-block;
        padding: 4px 10px;
        background: #D1FAE5;
        color: #065F46;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .badge-rejected {
        display: inline-block;
        padding: 4px 10px;
        background: #FEE2E2;
        color: #991B1B;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .badge-type {
        display: inline-block;
        padding: 4px 10px;
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
        gap: 6px;
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
    
    .btn-approve {
        background: #D1FAE5;
        color: #065F46;
    }
    
    .btn-approve:hover {
        background: #A7F3D0;
    }
    
    .btn-reject {
        background: #FEE2E2;
        color: #DC2626;
    }
    
    .btn-reject:hover {
        background: #FECACA;
    }
    
    .employee-link {
        color: #1D4ED8;
        text-decoration: none;
        font-weight: 500;
    }
    
    .employee-link:hover {
        text-decoration: underline;
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
    
    .pagination-container {
        padding: 20px;
        border-top: 1px solid #E5E7EB;
    }
    
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .table-modern thead th,
        .table-modern tbody td {
            padding: 10px 12px;
        }
    }
</style>

<div class="container-fluid">
    <div class="page-header">
        <h1 class="page-title">Leave Requests</h1>
        <a href="{{ route('leaves.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> Request Leave
        </a>
    </div>
    
    <div class="data-card">
        <div class="table-container">
            <table class="table-modern">
                <thead>
                    <tr>
                        @can('manage-leaves')
                        <th>Employee</th>
                        @endcan
                        <th>Type</th>
                        <th>Dates</th>
                        <th>Duration</th>
                        <th>Status</th>
                        @can('process', App\Models\Leave::class)
                        <th style="width: 100px;">Actions</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaves as $leave)
                    <tr>
                        @can('manage-leaves')
                        <td>
                            <a href="{{ route('employees.show', $leave->employee_id) }}" class="employee-link">
                                {{ $leave->employee->getFullName() }}
                            </a>
                        </td>
                        @endcan
                        <td>
                            <span class="badge-type 
                                @if($leave->type == 'paid') badge-paid
                                @elseif($leave->type == 'sick') badge-sick
                                @elseif($leave->type == 'unpaid') badge-unpaid
                                @else badge-exceptional @endif">
                                {{ ucfirst($leave->type) }}
                            </span>
                        </td>
                        <td style="font-size: 0.75rem;">
                            {{ $leave->start_date->format('d/m/Y') }}<br>→<br>{{ $leave->end_date->format('d/m/Y') }}
                        </td>
                        <td>{{ $leave->duration }} day(s)</td>
                        <td>
                            @if($leave->status == 'pending')
                                <span class="badge-pending"><i class="fas fa-clock"></i> Pending</span>
                            @elseif($leave->status == 'approved')
                                <span class="badge-approved"><i class="fas fa-check-circle"></i> Approved</span>
                            @else
                                <span class="badge-rejected"><i class="fas fa-times-circle"></i> Rejected</span>
                            @endif
                        </td>
                        @can('process', $leave)
                        <td>
                            @if($leave->isPending())
                            <div class="action-buttons">
                                <a href="{{ route('leaves.show', $leave) }}" class="btn-action btn-view" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form method="POST" action="{{ route('leaves.approve', $leave) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-action btn-approve" title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('leaves.reject', $leave) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-action btn-reject" title="Reject">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                            @else
                            <a href="{{ route('leaves.show', $leave) }}" class="btn-action btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            @endif
                        </td>
                        @endcan
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ (Auth::user()->isAdmin() || Auth::user()->isManager()) ? '8' : '6' }}" class="empty-state">
                            <i class="fas fa-calendar-alt"></i>
                            No leave requests found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($leaves->hasPages())
        <div class="pagination-container">
            {{ $leaves->links() }}
        </div>
        @endif
    </div>
</div>
@endsection