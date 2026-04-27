@extends('layouts.app')

@section('title', 'Audit Logs Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Audit Logs Dashboard</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h5>Total Logs</h5>
                    <h2>{{ $stats['total'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h5>Last 7 Days</h5>
                    <h2>{{ $stats['last_7_days'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h5>Last 30 Days</h5>
                    <h2>{{ $stats['last_30_days'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h5>Today</h5>
                    <h2>{{ $stats['today'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Actions Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="actionsChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Activity by Hour (Today)</h5>
                </div>
                <div class="card-body">
                    <canvas id="hourlyChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Activities</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
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
                                    <td>{{ $activity->created_at->format('d/m/Y H:i:s') }}</a></td>
                                    <td>
                                        @if($activity->user)
                                            {{ $activity->user->getFullName() }}
                                        @else
                                            System
                                        @endif
                                    </a></td>
                                    <td>{!! $activity->getActionBadge() !!}</a></td>
                                    <td>{{ $activity->entity_type }} #{{ $activity->entity_id }}</a></td>
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
                                                echo implode(', ', array_slice($changes, 0, 2));
                                                if(count($changes) > 2) echo '...';
                                            @endphp
                                        @elseif($activity->action == 'create')
                                            Created new {{ $activity->entity_type }}
                                        @elseif($activity->action == 'delete')
                                            Deleted {{ $activity->entity_type }}
                                        @else
                                            {{ $activity->action }}
                                        @endif
                                    </a>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
    const actionsCtx = document.getElementById('actionsChart').getContext('2d');
    const actionsData = @json($stats['by_action']->pluck('count', 'action'));
    
    new Chart(actionsCtx, {
        type: 'pie',
        data: {
            labels: Object.keys(actionsData).map(a => a.toUpperCase()),
            datasets: [{
                data: Object.values(actionsData),
                backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6c757d', '#007bff'],
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
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endpush