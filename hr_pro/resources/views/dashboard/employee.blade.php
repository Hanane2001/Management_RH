@extends('layouts.app')

@section('title', 'Employee Dashboard')

@section('content')
<style>
    /* Welcome Section */
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
    
    .welcome-subtitle {
        font-family: 'Roboto', sans-serif;
        color: #6B7280;
        font-size: 0.9rem;
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
        border-radius: 20px;
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
        transform: translateY(-2px);
    }
    
    .stat-card.info {
        background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
        color: white;
        border: none;
    }
    
    .stat-card.primary {
        background: linear-gradient(135deg, #1D4ED8 0%, #1E3A8A 100%);
        color: white;
        border: none;
    }
    
    .stat-card.success {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        color: white;
        border: none;
    }
    
    .stat-card.warning {
        background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        color: white;
        border: none;
    }
    
    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }
    
    .stat-title {
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.8;
    }
    
    .stat-icon {
        font-size: 1.5rem;
        opacity: 0.3;
    }
    
    .stat-value {
        font-family: 'Inter', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-family: 'Roboto', sans-serif;
        font-size: 0.7rem;
        opacity: 0.8;
    }
    
    /* Data Cards */
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
    
    .btn-request {
        background: #1D4ED8;
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .btn-request:hover {
        background: #1E3A8A;
        transform: translateY(-1px);
        color: white;
    }
    
    .card-body-custom {
        padding: 20px;
    }
    
    /* Tables */
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
        padding: 10px 12px;
        font-family: 'Inter', sans-serif;
        font-size: 0.7rem;
        font-weight: 600;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #E5E7EB;
        text-align: left;
    }
    
    .table-modern tbody td {
        padding: 10px 12px;
        font-size: 0.8rem;
        color: #374151;
        border-bottom: 1px solid #F3F4F6;
    }
    
    .table-modern tbody tr:hover td {
        background: #F9FAFB;
    }
    
    /* Badges */
    .badge-custom {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .badge-pending {
        background: #FEF3C7;
        color: #D97706;
    }
    
    .badge-approved {
        background: #D1FAE5;
        color: #065F46;
    }
    
    .badge-rejected {
        background: #FEE2E2;
        color: #991B1B;
    }
    
    .badge-active {
        background: #D1FAE5;
        color: #065F46;
    }
    
    .badge-expired {
        background: #F3F4F6;
        color: #6B7280;
    }
    
    /* Quick Actions */
    .actions-grid {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .btn-action {
        padding: 12px;
        border-radius: 12px;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
    }
    
    .btn-checkin {
        background: #10B981;
        color: white;
    }
    
    .btn-checkin:hover {
        background: #059669;
        transform: translateY(-2px);
    }
    
    .btn-checkout {
        background: #EF4444;
        color: white;
    }
    
    .btn-checkout:hover {
        background: #DC2626;
        transform: translateY(-2px);
    }
    
    .btn-leave {
        background: #1D4ED8;
        color: white;
        text-decoration: none;
        text-align: center;
    }
    
    .btn-leave:hover {
        background: #1E3A8A;
        transform: translateY(-2px);
    }
    
    /* Performance Section */
    .performance-stats {
        text-align: center;
        padding: 10px;
    }
    
    .performance-score {
        font-family: 'Inter', sans-serif;
        font-size: 3rem;
        font-weight: 800;
        color: #1D4ED8;
        margin-bottom: 5px;
    }
    
    .performance-label {
        font-family: 'Roboto', sans-serif;
        color: #6B7280;
        font-size: 0.85rem;
        margin-bottom: 20px;
    }
    
    .progress-custom {
        height: 10px;
        background: #E5E7EB;
        border-radius: 10px;
        overflow: hidden;
        margin: 15px 0;
    }
    
    .progress-bar-custom {
        height: 100%;
        background: #10B981;
        border-radius: 10px;
        transition: width 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        color: white;
    }
    
    .evaluation-count {
        margin-top: 15px;
        font-family: 'Roboto', sans-serif;
        font-size: 0.8rem;
        color: #6B7280;
    }
    
    .empty-state {
        text-align: center;
        padding: 40px;
        color: #9CA3AF;
    }
    
    .empty-state i {
        font-size: 2rem;
        margin-bottom: 10px;
        display: block;
    }
    
    /* Two Columns Layout */
    .two-columns {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }
    
    @media (max-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
    }
    
    @media (max-width: 768px) {
        .two-columns {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .stat-value {
            font-size: 1.5rem;
        }
        
        .welcome-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="container-fluid">

    <div class="welcome-section">
        <h1 class="welcome-title">Welcome, {{ auth()->user()->getFullName() }}!</h1>
        <p class="welcome-subtitle">Here's your personal HR dashboard overview</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card info">
            <div class="stat-header">
                <span class="stat-title">Leave Balance</span>
                <span class="stat-icon"><i class="fas fa-calendar-alt"></i></span>
            </div>
            <div class="stat-value">{{ $stats['leave_balance'] }} / {{ $stats['total_leave_days'] }}</div>
            <div class="stat-label">Days remaining</div>
        </div>
        
        <div class="stat-card primary">
            <div class="stat-header">
                <span class="stat-title">Total Leaves</span>
                <span class="stat-icon"><i class="fas fa-list"></i></span>
            </div>
            <div class="stat-value">{{ $stats['my_leaves'] }}</div>
            <div class="stat-label">Total requests</div>
        </div>
        
        <div class="stat-card success">
            <div class="stat-header">
                <span class="stat-title">Approved Leaves</span>
                <span class="stat-icon"><i class="fas fa-check-circle"></i></span>
            </div>
            <div class="stat-value">{{ $stats['approved_leaves'] }}</div>
            <div class="stat-label">Approved requests</div>
        </div>
        
        <div class="stat-card warning">
            <div class="stat-header">
                <span class="stat-title">Pending Leaves</span>
                <span class="stat-icon"><i class="fas fa-clock"></i></span>
            </div>
            <div class="stat-value">{{ $stats['pending_leaves'] }}</div>
            <div class="stat-label">Awaiting approval</div>
        </div>
    </div>
    
    <div class="two-columns">
        <div class="data-card">
            <div class="card-header-custom">
                <h5>
                    <i class="fas fa-calendar-alt"></i> My Recent Leaves
                </h5>
                <a href="{{ route('leaves.create') }}" class="btn-request">
                    <i class="fas fa-plus"></i> Request Leave
                </a>
            </div>
            <div class="card-body-custom">
                <div class="table-container">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Dates</th>
                                <th>Duration</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($my_leaves as $leave)
                            <tr>
                                <td>{{ ucfirst($leave->type) }}</a>
                                <td>
                                    <small>{{ $leave->start_date->format('d/m/Y') }}</small><br>
                                    <span style="font-size: 0.7rem;">→</span><br>
                                    <small>{{ $leave->end_date->format('d/m/Y') }}</small>
                                </a>
                                <td>{{ $leave->duration }} day(s)</a>
                                <td>
                                    <span class="badge-custom 
                                        @if($leave->status == 'pending') badge-pending
                                        @elseif($leave->status == 'approved') badge-approved
                                        @else badge-rejected @endif">
                                        <i class="fas 
                                            @if($leave->status == 'pending') fa-clock
                                            @elseif($leave->status == 'approved') fa-check
                                            @else fa-times @endif"></i>
                                        {{ ucfirst($leave->status) }}
                                    </span>
                                </a>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="empty-state">
                                    <i class="fas fa-calendar-minus"></i>
                                    No leave requests found
                                </a>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="data-card">
            <div class="card-header-custom">
                <h5>
                    <i class="fas fa-file-signature"></i> My Contracts
                </h5>
            </div>
            <div class="card-body-custom">
                <div class="table-container">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th>Position</th>
                                <th>Type</th>
                                <th>Start Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($my_contracts as $contract)
                            <tr>
                                <td>{{ $contract->position }}</a>
                                <td>{{ ucfirst($contract->type) }}</a>
                                <td>{{ $contract->start_date->format('d/m/Y') }}</a>
                                <td>
                                    <span class="badge-custom {{ $contract->isActive() ? 'badge-active' : 'badge-expired' }}">
                                        <i class="fas {{ $contract->isActive() ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                        {{ $contract->isActive() ? 'Active' : 'Expired' }}
                                    </span>
                                </a>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="empty-state">
                                    <i class="fas fa-file-contract"></i>
                                    No contracts found
                                </a>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="two-columns">
        <div class="data-card">
            <div class="card-header-custom">
                <h5>
                    <i class="fas fa-bolt"></i> Quick Actions
                </h5>
            </div>
            <div class="card-body-custom">
                <div class="actions-grid">
                    <form method="POST" action="{{ route('attendances.check-in') }}">
                        @csrf
                        <button type="submit" class="btn-action btn-checkin">
                            <i class="fas fa-sign-in-alt"></i> Check In
                        </button>
                    </form>
                    <form method="POST" action="{{ route('attendances.check-out') }}">
                        @csrf
                        <button type="submit" class="btn-action btn-checkout">
                            <i class="fas fa-sign-out-alt"></i> Check Out
                        </button>
                    </form>
                    <a href="{{ route('leaves.create') }}" class="btn-action btn-leave">
                        <i class="fas fa-calendar-plus"></i> Request Leave
                    </a>
                </div>
            </div>
        </div>
        
        <div class="data-card">
            <div class="card-header-custom">
                <h5>
                    <i class="fas fa-chart-line"></i> My Performance
                </h5>
            </div>
            <div class="card-body-custom">
                <div class="performance-stats">
                    <div class="performance-score">
                        {{ number_format($stats['my_average_score'] ?? 0, 1) }}%
                    </div>
                    <div class="performance-label">Average Evaluation Score</div>
                    
                    <div class="progress-custom">
                        <div class="progress-bar-custom" style="width: {{ $stats['my_average_score'] ?? 0 }}%">
                            @if(($stats['my_average_score'] ?? 0) > 20)
                                {{ number_format($stats['my_average_score'] ?? 0, 1) }}%
                            @endif
                        </div>
                    </div>
                    
                    <div class="evaluation-count">
                        <i class="fas fa-star" style="color: #F59E0B;"></i>
                        Total Evaluations: {{ $stats['my_evaluations'] ?? 0 }}
                    </div>
                    
                    @if(($stats['my_best_score'] ?? 0) > 0)
                    <div class="evaluation-count" style="margin-top: 10px;">
                        <i class="fas fa-trophy" style="color: #F59E0B;"></i>
                        Best Score: {{ number_format($stats['my_best_score'], 1) }}%
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection