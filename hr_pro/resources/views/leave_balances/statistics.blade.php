@extends('layouts.app')

@section('title', 'Leave Balance Statistics')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Leave Balance Statistics - {{ date('Y') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h5>Total Employees</h5>
                    <h2>{{ $stats['total_employees'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h5>Total Days Allocated</h5>
                    <h2>{{ number_format($stats['total_days_allocated']) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h5>Total Days Used</h5>
                    <h2>{{ number_format($stats['total_days_used']) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h5>Low Balance (&lt;5 days)</h5>
                    <h2>{{ $stats['employees_with_low_balance'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Employees with Critical Balance (&lt;5 days)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Department</th>
                                    <th>Remaining Days</th>
                                    <th>Usage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowBalances as $balance)
                                <tr>
                                    <td>{{ $balance->employee->getFullName() }}</a></td>
                                    <td>{{ $balance->employee->department->name ?? 'N/A' }}</a></td>
                                    <td><span class="text-danger fw-bold">{{ $balance->remaining_days }}</span></a></td>
                                    <td>{{ number_format($balance->getUsedPercentage(), 1) }}%</a></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-success">No employees with critical balance</a>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Balance Overview</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <canvas id="balanceChart" width="400" height="300"></canvas>
                        <div class="mt-3">
                            <p><strong>Employees with Zero Balance:</strong> {{ $stats['employees_with_zero_balance'] }}</p>
                            <p><strong>Average Days per Employee:</strong> {{ number_format($stats['total_days_allocated'] / max($stats['total_balances'], 1), 1) }} days</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('balanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Used Days ({{ $stats['total_days_used'] }})', 'Remaining Days ({{ $stats['total_days_allocated'] - $stats['total_days_used'] }})'],
            datasets: [{
                data: [{{ $stats['total_days_used'] }}, {{ $stats['total_days_allocated'] - $stats['total_days_used'] }}],
                backgroundColor: ['#ffc107', '#28a745'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush@extends('layouts.app')

@section('title', 'Leave Balance Statistics')

@section('content')
<style>
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
    
    .stat-icon.teal {
        background: #F0FDF4;
        color: #10B981;
    }
    
    .stat-icon.orange {
        background: #FFF7ED;
        color: #F97316;
    }
    
    .stat-icon.red {
        background: #FEF2F2;
        color: #EF4444;
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
    }
    
    .card-header-custom h5 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 1rem;
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
        padding: 20px;
    }
    
    /* Table */
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
    
    .critical-balance {
        font-weight: 700;
        color: #EF4444;
    }
    
    .progress-custom {
        height: 8px;
        background: #E5E7EB;
        border-radius: 10px;
        overflow: hidden;
        width: 100px;
    }
    
    .progress-bar-custom {
        height: 100%;
        background: #EF4444;
        border-radius: 10px;
    }
    
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
    
    .chart-container {
        max-width: 300px;
        margin: 0 auto;
    }
    
    .summary-stats {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #E5E7EB;
    }
    
    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    
    .summary-label {
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        color: #6B7280;
    }
    
    .summary-value {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        color: #1F2937;
    }
    
    .text-success {
        color: #10B981;
    }
    
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
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
    <div class="page-header">
        <h1 class="page-title">Leave Balance Statistics</h1>
        <p class="page-subtitle">Overview of leave balances for {{ date('Y') }}</p>
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
            <div class="stat-value">{{ $stats['total_employees'] }}</div>
            <div class="stat-trend">Active employees</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Total Days Allocated</span>
                <div class="stat-icon teal">
                    <i class="fas fa-calendar-plus"></i>
                </div>
            </div>
            <div class="stat-value">{{ number_format($stats['total_days_allocated']) }}</div>
            <div class="stat-trend">Days allocated for {{ date('Y') }}</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Total Days Used</span>
                <div class="stat-icon orange">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
            <div class="stat-value">{{ number_format($stats['total_days_used']) }}</div>
            <div class="stat-trend">{{ number_format(($stats['total_days_used'] / max($stats['total_days_allocated'], 1)) * 100, 1) }}% usage rate</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Low Balance (<5 days)</span>
                <div class="stat-icon red">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
            <div class="stat-value">{{ $stats['employees_with_low_balance'] }}</div>
            <div class="stat-trend">Employees with critical balance</div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="data-card">
                <div class="card-header-custom">
                    <h5>
                        <i class="fas fa-exclamation-circle"></i> Employees with Critical Balance (&lt;5 days)
                    </h5>
                </div>
                <div class="card-body-custom" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="table-modern">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Department</th>
                                    <th>Remaining Days</th>
                                    <th>Usage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowBalances as $balance)
                                <tr>
                                    <td>{{ $balance->employee->getFullName() }}</td>
                                    <td>{{ $balance->employee->department->name ?? '—' }}</td>
                                    <td><span class="critical-balance">{{ $balance->remaining_days }} days</span></td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <div class="progress-custom">
                                                <div class="progress-bar-custom" style="width: {{ $balance->getUsedPercentage() }}%"></div>
                                            </div>
                                            <span style="font-size: 0.7rem;">{{ number_format($balance->getUsedPercentage(), 1) }}%</span>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="empty-state">
                                        <i class="fas fa-check-circle" style="color: #10B981;"></i>
                                        No employees with critical balance
                                    </a>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-5 mb-4">
            <div class="data-card">
                <div class="card-header-custom">
                    <h5>
                        <i class="fas fa-chart-pie"></i> Balance Overview
                    </h5>
                </div>
                <div class="card-body-custom">
                    <div class="chart-container">
                        <canvas id="balanceChart" width="300" height="300"></canvas>
                    </div>
                    
                    <div class="summary-stats">
                        <div class="summary-item">
                            <span class="summary-label">Employees with Zero Balance</span>
                            <span class="summary-value">{{ $stats['employees_with_zero_balance'] }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Average Days per Employee</span>
                            <span class="summary-value">{{ number_format($stats['total_days_allocated'] / max($stats['total_balances'], 1), 1) }} days</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Remaining Days Total</span>
                            <span class="summary-value">{{ number_format($stats['total_days_allocated'] - $stats['total_days_used']) }} days</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('balanceChart').getContext('2d');
        
        const usedDays = {{ $stats['total_days_used'] }};
        const remainingDays = {{ $stats['total_days_allocated'] - $stats['total_days_used'] }};
        
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Used Days', 'Remaining Days'],
                datasets: [{
                    data: [usedDays, remainingDays],
                    backgroundColor: ['#F59E0B', '#10B981'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                family: 'Inter, sans-serif',
                                size: 12
                            },
                            padding: 15
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = usedDays + remainingDays;
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return `${label}: ${value.toLocaleString()} days (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '65%'
            }
        });
    });
</script>
@endpush