@extends('layouts.app')

@section('title', 'Audit Logs Dashboard')

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
    
    /* Badges */
    .badge-action {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .badge-create {
        background: #D1FAE5;
        color: #065F46;
    }
    
    .badge-update {
        background: #FEF3C7;
        color: #D97706;
    }
    
    .badge-delete {
        background: #FEE2E2;
        color: #991B1B;
    }
    
    .badge-login {
        background: #EFF6FF;
        color: #1D4ED8;
    }
    
    .badge-other {
        background: #F3F4F6;
        color: #6B7280;
    }
    
    /* Chart Container */
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 24px;
    }
    
    .chart-container {
        min-height: 300px;
    }
    
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        
        .charts-grid {
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
    <div class="page-header">
        <div>
            <h1 class="page-title">Audit Logs Dashboard</h1>
            <p class="page-subtitle">Monitor system activity and user actions</p>
        </div>
    </div>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Total Logs</span>
                <div class="stat-icon blue">
                    <i class="fas fa-database"></i>
                </div>
            </div>
            <div class="stat-value">{{ number_format($stats['total']) }}</div>
            <div class="stat-trend">All time records</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Last 7 Days</span>
                <div class="stat-icon teal">
                    <i class="fas fa-calendar-week"></i>
                </div>
            </div>
            <div class="stat-value">{{ number_format($stats['last_7_days']) }}</div>
            <div class="stat-trend">Recent activity</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Last 30 Days</span>
                <div class="stat-icon orange">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            <div class="stat-value">{{ number_format($stats['last_30_days']) }}</div>
            <div class="stat-trend">Monthly overview</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Today</span>
                <div class="stat-icon purple">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
            <div class="stat-value">{{ number_format($stats['today']) }}</div>
            <div class="stat-trend">Today's activity</div>
        </div>
    </div>

    <div class="charts-grid">
        <div class="data-card">
            <div class="card-header-custom">
                <h5>
                    <i class="fas fa-chart-pie"></i> Actions Distribution
                </h5>
            </div>
            <div class="card-body-custom">
                <div class="chart-container">
                    <canvas id="actionsChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="data-card">
            <div class="card-header-custom">
                <h5>
                    <i class="fas fa-chart-line"></i> Activity by Hour (Today)
                </h5>
            </div>
            <div class="card-body-custom">
                <div class="chart-container">
                    <canvas id="hourlyChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="data-card">
        <div class="card-header-custom">
            <h5>
                <i class="fas fa-history"></i> Recent Activities
            </h5>
        </div>
        <div class="card-body-custom" style="padding: 0;">
            <div class="table-container" style="overflow-x: auto;">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Entity</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['recent_activities'] as $activity)
                        <tr>
                            <td style="white-space: nowrap;">{{ $activity->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>
                                <strong>{{ $activity->user ? $activity->user->getFullName() : 'System' }}</strong>
                            </td>
                            <td>
                                @php
                                    $badgeClass = match($activity->action) {
                                        'create' => 'badge-create',
                                        'update' => 'badge-update',
                                        'delete' => 'badge-delete',
                                        'login', 'logout', 'login_success' => 'badge-login',
                                        default => 'badge-other'
                                    };
                                @endphp
                                <span class="badge-action {{ $badgeClass }}">
                                    <i class="fas 
                                        @if($activity->action == 'create') fa-plus
                                        @elseif($activity->action == 'update') fa-edit
                                        @elseif($activity->action == 'delete') fa-trash
                                        @elseif($activity->action == 'login') fa-sign-in-alt
                                        @elseif($activity->action == 'logout') fa-sign-out-alt
                                        @else fa-clock @endif"></i>
                                    {{ ucfirst($activity->action) }}
                                </span>
                            </td>
                            <td>
                                <span style="font-weight: 500;">{{ $activity->entity_type }}</span>
                                <span class="text-muted">#{{ $activity->entity_id }}</span>
                            </td>
                            <td>
                                @if($activity->action == 'update')
                                    @php
                                        $changes = [];
                                        if($activity->new_values) {
                                            foreach($activity->new_values as $key => $value) {
                                                if(isset($activity->old_values[$key]) && $activity->old_values[$key] != $value) {
                                                    $changes[] = $key;
                                                }
                                            }
                                        }
                                        echo '<span class="text-muted">Updated: </span>' . implode(', ', array_slice($changes, 0, 2));
                                        if(count($changes) > 2) echo ' +' . (count($changes) - 2) . ' more';
                                    @endphp
                                @elseif($activity->action == 'create')
                                    <span class="text-muted">Created new</span> {{ $activity->entity_type }}
                                @elseif($activity->action == 'delete')
                                    <span class="text-muted">Deleted</span> {{ $activity->entity_type }}
                                @elseif(in_array($activity->action, ['login', 'logout', 'login_success']))
                                    <span class="text-muted">Authentication</span>
                                @else
                                    <span class="text-muted">{{ $activity->action }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const actionsCtx = document.getElementById('actionsChart').getContext('2d');
        const actionsData = @json($stats['by_action']->pluck('count', 'action'));
        
        const actionLabels = Object.keys(actionsData).map(a => a.charAt(0).toUpperCase() + a.slice(1));
        const actionCounts = Object.values(actionsData);
        
        new Chart(actionsCtx, {
            type: 'doughnut',
            data: {
                labels: actionLabels,
                datasets: [{
                    data: actionCounts,
                    backgroundColor: ['#F59E0B', '#10B981', '#EF4444', '#1D4ED8', '#8B5CF6', '#6B7280'],
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
                                size: 11
                            },
                            padding: 12,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = actionCounts.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return `${label}: ${value.toLocaleString()} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '60%'
            }
        });

        const hourlyCtx = document.getElementById('hourlyChart').getContext('2d');
        const hourlyData = @json($stats['by_hour']);
        const hours = Array.from({length: 24}, (_, i) => i);
        const counts = hours.map(hour => {
            const found = hourlyData.find(item => item.hour == hour);
            return found ? found.count : 0;
        });
        
        new Chart(hourlyCtx, {
            type: 'line',
            data: {
                labels: hours.map(h => `${h}:00`),
                datasets: [{
                    label: 'Activities',
                    data: counts,
                    borderColor: '#1D4ED8',
                    backgroundColor: 'rgba(29, 78, 216, 0.05)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#1D4ED8',
                    pointBorderColor: 'white',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Activities: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0,
                            font: {
                                size: 10
                            }
                        },
                        grid: {
                            color: '#E5E7EB',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 9
                            },
                            maxRotation: 45,
                            minRotation: 45
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>
@endpush