@extends('layouts.app')

@section('title', 'Manager Dashboard')

@section('content')
<style>
    .welcome-section {
        margin-bottom: 30px;
    }
    
    .welcome-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 1.8rem;
        color: #1F2937;
        margin-bottom: 5px;
    }
    
    .welcome-text {
        font-family: 'Roboto', sans-serif;
        color: #6B7280;
    }
    
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
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
        font-size: 0.85rem;
        font-weight: 500;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .stat-icon {
        width: 40px;
        height: 40px;
        background: #EFF6FF;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #1D4ED8;
        font-size: 1.2rem;
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
        color: #10B981;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    /* Cards */
    .card-modern {
        background: white;
        border-radius: 16px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
        margin-bottom: 24px;
    }
    
    .card-header-modern {
        padding: 16px 20px;
        border-bottom: 1px solid #E5E7EB;
        background: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .card-header-modern h5 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 1rem;
        color: #1F2937;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .card-header-modern h5 i {
        color: #1D4ED8;
        font-size: 1rem;
    }
    
    .card-body-modern {
        padding: 0;
    }
    
    /* Table */
    .table-simple {
        width: 100%;
        font-family: 'Roboto', sans-serif;
    }
    
    .table-simple thead th {
        padding: 12px 20px;
        background: #F9FAFB;
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #E5E7EB;
    }
    
    .table-simple tbody td {
        padding: 12px 20px;
        font-size: 0.85rem;
        color: #374151;
        border-bottom: 1px solid #F3F4F6;
    }
    
    .table-simple tbody tr:hover td {
        background: #F9FAFB;
    }
    
    /* Badges */
    .badge-simple {
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
        background: #DBEAFE;
        color: #1E40AF;
    }
    
    /* Buttons */
    .btn-icon {
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-approve {
        background: #10B981;
        color: white;
    }
    
    .btn-approve:hover {
        background: #059669;
    }
    
    .btn-reject {
        background: #EF4444;
        color: white;
        margin-left: 5px;
    }
    
    .btn-reject:hover {
        background: #DC2626;
    }
    
    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #9CA3AF;
        font-family: 'Roboto', sans-serif;
        font-size: 0.85rem;
    }
    
    /* Layout */
    .two-columns {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }
    
    @media (max-width: 768px) {
        .two-columns {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        
        .stat-value {
            font-size: 1.5rem;
        }
    }
    
    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container-fluid">
    <div class="welcome-section">
        <h1 class="welcome-title">Manager Dashboard</h1>
        <p class="welcome-text">Welcome back, {{ auth()->user()->getFullName() }}</p>
    </div>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Team Members</span>
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="stat-value">{{ $stats['total_employees'] }}</div>
            <div class="stat-trend">
                <i class="fas fa-user-plus"></i> Active team members
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Pending Leaves</span>
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div class="stat-value">{{ $stats['pending_leaves'] }}</div>
            <div class="stat-trend" style="color: #F59E0B;">
                <i class="fas fa-hourglass-half"></i> Awaiting approval
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Active Contracts</span>
                <div class="stat-icon">
                    <i class="fas fa-file-signature"></i>
                </div>
            </div>
            <div class="stat-value">{{ $stats['active_contracts'] }}</div>
            <div class="stat-trend" style="color: #10B981;">
                <i class="fas fa-check-circle"></i> Current contracts
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Avg Score</span>
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <div class="stat-value">{{ number_format($stats['average_score'] ?? 0, 1) }}%</div>
            <div class="stat-trend" style="color: #8B5CF6;">
                <i class="fas fa-chart-line"></i> Performance average
            </div>
        </div>
    </div>
    
    <div class="two-columns">
        <div class="card-modern">
            <div class="card-header-modern">
                <h5>
                    <i class="fas fa-users"></i> Team Members
                </h5>
                <span style="font-size: 0.7rem; color: #6B7280;">Recently joined</span>
            </div>
            <div class="card-body-modern">
                <table class="table-simple">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Position</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_employees as $employee)
                        <tr>
                            <td>{{ $employee->getFullName() }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->contracts->first()->position ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="empty-state">No team members found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-modern">
            <div class="card-header-modern">
                <h5>
                    <i class="fas fa-calendar-alt"></i> Pending Leave Requests
                </h5>
                <span style="font-size: 0.7rem; color: #6B7280;">Need action</span>
            </div>
            <div class="card-body-modern">
                <table class="table-simple">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Type</th>
                            <th>Dates</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pending_leaves as $leave)
                        <tr>
                            <td>{{ $leave->employee->getFullName() }}</td>
                            <td>
                                <span class="badge-simple 
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
                            <td style="white-space: nowrap;">
                                <form method="POST" action="{{ route('leaves.approve', $leave) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-icon btn-approve" title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('leaves.reject', $leave) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-icon btn-reject" title="Reject">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="empty-state">
                                <i class="fas fa-check-circle" style="font-size: 2rem; margin-bottom: 10px; display: block; color: #10B981;"></i>
                                No pending leave requests
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection