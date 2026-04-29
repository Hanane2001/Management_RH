@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    /* Header */
    .page-header {
        margin-bottom: 24px;
    }
    
    .page-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 1.5rem;
        color: #1F2937;
        margin: 0 0 5px 0;
    }
    
    .page-subtitle {
        font-family: 'Roboto', sans-serif;
        color: #6B7280;
        font-size: 0.85rem;
    }
    
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        border: 1px solid #E5E7EB;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card:hover {
        border-color: #1D4ED8;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    }
    
    .stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }
    
    .stat-title {
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        font-weight: 500;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    
    .stat-icon.blue {
        background: #EFF6FF;
        color: #1D4ED8;
    }
    
    .stat-icon.orange {
        background: #FFF7ED;
        color: #F97316;
    }
    
    .stat-icon.teal {
        background: #F0FDF4;
        color: #10B981;
    }
    
    .stat-icon.purple {
        background: #F3E8FF;
        color: #7E22CE;
    }
    
    .stat-value {
        font-family: 'Inter', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 5px;
    }
    
    .stat-trend {
        font-family: 'Roboto', sans-serif;
        font-size: 0.75rem;
        color: #6B7280;
    }
    
    /* Cards */
    .data-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
        margin-bottom: 24px;
    }
    
    .card-header-custom {
        padding: 16px 20px;
        border-bottom: 1px solid #E5E7EB;
        background: #F9FAFB;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .card-header-custom h5 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.95rem;
        color: #1F2937;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .card-header-custom h5 i {
        color: #1D4ED8;
    }
    
    .card-body-custom {
        padding: 0;
    }
    
    /* Tables */
    .table-modern {
        width: 100%;
        font-family: 'Roboto', sans-serif;
        border-collapse: collapse;
    }
    
    .table-modern thead th {
        background: #F9FAFB;
        padding: 12px 16px;
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
        padding: 12px 16px;
        font-size: 0.85rem;
        color: #374151;
        border-bottom: 1px solid #F3F4F6;
    }
    
    .table-modern tbody tr:hover td {
        background: #F9FAFB;
    }
    
    /* Badges */
    .badge-type {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .badge-paid {
        background: #D1FAE5;
        color: #065F46;
    }
    
    .badge-sick {
        background: #FEF3C7;
        color: #D97706;
    }
    
    .badge-unpaid {
        background: #FEE2E2;
        color: #991B1B;
    }
    
    .badge-exceptional {
        background: #EFF6FF;
        color: #1D4ED8;
    }
    
    .btn-approve {
        background: #D1FAE5;
        color: #065F46;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-approve:hover {
        background: #A7F3D0;
    }
    
    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #9CA3AF;
    }
    
    .empty-state i {
        font-size: 2rem;
        margin-bottom: 10px;
        display: block;
    }
    
    /* Two columns layout */
    .two-columns {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 24px;
    }
    
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        
        .two-columns {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .stat-value {
            font-size: 1.5rem;
        }
        
        .table-modern thead th,
        .table-modern tbody td {
            padding: 8px 12px;
        }
    }
    
    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Admin Dashboard</h1>
            <p class="page-subtitle">Welcome back, {{ auth()->user()->getFullName() }}!</p>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Total Employees</span>
                <div class="stat-icon blue">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="stat-value">{{ number_format($stats['total_employees']) }}</div>
            <div class="stat-trend">Active employees in the system</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Pending Approvals</span>
                <div class="stat-icon orange">
                    <i class="fas fa-user-clock"></i>
                </div>
            </div>
            <div class="stat-value">{{ number_format($stats['pending_approvals'] ?? 0) }}</div>
            <div class="stat-trend">Awaiting account activation</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Pending Leaves</span>
                <div class="stat-icon teal">
                    <i class="fas fa-calendar-times"></i>
                </div>
            </div>
            <div class="stat-value">{{ number_format($stats['pending_leaves']) }}</div>
            <div class="stat-trend">Leave requests to review</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Active Contracts</span>
                <div class="stat-icon purple">
                    <i class="fas fa-file-signature"></i>
                </div>
            </div>
            <div class="stat-value">{{ number_format($stats['active_contracts']) }}</div>
            <div class="stat-trend">Current active contracts</div>
        </div>
    </div>
    
    <!-- Two Columns Layout -->
    <div class="two-columns">
        <!-- Recent Employees -->
        <div class="data-card">
            <div class="card-header-custom">
                <h5>
                    <i class="fas fa-user-plus"></i> Recent Employees
                </h5>
                <span style="font-size: 0.7rem; color: #6B7280;">Last 5 added</span>
            </div>
            <div class="card-body-custom">
                <div class="table-container" style="overflow-x: auto;">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Department</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_employees as $employee)
                            <tr>
                                <td><strong>{{ $employee->getFullName() }}</strong></td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->department->name ?? '—' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="empty-state">
                                    <i class="fas fa-users-slash"></i>
                                    No employees found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Pending Approvals -->
        <div class="data-card">
            <div class="card-header-custom">
                <h5>
                    <i class="fas fa-user-check"></i> Pending Approvals
                </h5>
                <span style="font-size: 0.7rem; color: #6B7280;">Needs action</span>
            </div>
            <div class="card-body-custom">
                <div class="table-container" style="overflow-x: auto;">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registered</th>
                                <th style="width: 80px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pending_approvals ?? [] as $user)
                            <tr>
                                <td><strong>{{ $user->getFullName() }}</strong></td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('employees.approve', $user) }}">
                                        @csrf
                                        <button type="submit" class="btn-approve">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="empty-state">
                                    <i class="fas fa-check-circle" style="color: #10B981;"></i>
                                    No pending approvals
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Second Row -->
    <div class="two-columns">
        <!-- Pending Leaves -->
        <div class="data-card">
            <div class="card-header-custom">
                <h5>
                    <i class="fas fa-clock"></i> Pending Leaves
                </h5>
                <span style="font-size: 0.7rem; color: #6B7280;">Awaiting review</span>
            </div>
            <div class="card-body-custom">
                <div class="table-container" style="overflow-x: auto;">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Type</th>
                                <th>Dates</th>
                                <th>Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pending_leaves as $leave)
                            <tr>
                                <td>{{ $leave->employee->getFullName() }}</td>
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
                                    {{ $leave->start_date->format('d/m/Y') }}<br>→ {{ $leave->end_date->format('d/m/Y') }}
                                </td>
                                <td>{{ $leave->duration }} days</a>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="empty-state">
                                    <i class="fas fa-calendar-check" style="color: #10B981;"></i>
                                    No pending leaves
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Recent Contracts -->
        <div class="data-card">
            <div class="card-header-custom">
                <h5>
                    <i class="fas fa-file-contract"></i> Recent Contracts
                </h5>
                <span style="font-size: 0.7rem; color: #6B7280;">Latest additions</span>
            </div>
            <div class="card-body-custom">
                <div class="table-container" style="overflow-x: auto;">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Position</th>
                                <th>Type</th>
                                <th>Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_contracts as $contract)
                            <tr>
                                <td>{{ $contract->employee->getFullName() }}</a>
                                <td>{{ $contract->position }}</a>
                                <td>
                                    <span class="badge-type 
                                        @if($contract->type == 'permanent') badge-paid
                                        @elseif($contract->type == 'fixed-term') badge-sick
                                        @else badge-exceptional @endif">
                                        {{ ucfirst($contract->type) }}
                                    </span>
                                </a>
                                <td>{{ number_format($contract->base_salary, 2) }} DH</a>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="empty-state">
                                    <i class="fas fa-file-contract"></i>
                                    No contracts found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection