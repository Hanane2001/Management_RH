@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Audit Log Dashboard</h1>
    
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h3>{{ number_format($stats['total']) }}</h3>
                    <p>Total Logs</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h3>{{ $stats['today'] }}</h3>
                    <p>Today</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h3>{{ $stats['last_7_days'] }}</h3>
                    <p>Last 7 Days</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h3>{{ $stats['last_30_days'] }}</h3>
                    <p>Last 30 Days</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Actions Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="actionsChart" height="250"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Activity by Hour (Today)</h5>
                </div>
                <div class="card-body">
                    <canvas id="hourlyChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-header bg-success text-white">
            <h5>Recent Activities</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
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
                        @foreach($stats['recent_activities'] as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $log->user ? $log->user->first_name . ' ' . $log->user->last_name : 'System' }}</td>
                            <td>{!! $log->getActionBadge() !!}</td>
                            <td>{{ $log->getEntityIcon() }} {{ $log->entity_type }}</td>
                            <td>{{ $log->getChangesSummary() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Actions Chart
    const actionsCtx = document.getElementById('actionsChart').getContext('2d');
    const actionsData = @json($stats['by_action']->pluck('count'));
    const actionsLabels = @json($stats['by_action']->pluck('action'));
    
    new Chart(actionsCtx, {
        type: 'bar',
        data: {
            labels: actionsLabels,
            datasets: [{
                label: 'Number of Actions',
                data: actionsData,
                backgroundColor: '#1D4ED8'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });
    
    // Hourly Chart
    const hourlyCtx = document.getElementById('hourlyChart').getContext('2d');
    const hourlyData = @json($stats['by_hour']->pluck('count'));
    const hourlyLabels = @json($stats['by_hour']->pluck('hour')->map(function($hour) {
        return $hour . ':00';
    }));
    
    new Chart(hourlyCtx, {
        type: 'line',
        data: {
            labels: hourlyLabels,
            datasets: [{
                label: 'Activities',
                data: hourlyData,
                borderColor: '#10B981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });
</script>
@endsection