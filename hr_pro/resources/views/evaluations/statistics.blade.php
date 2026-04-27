@extends('layouts.app')

@section('title', 'Evaluation Statistics')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Evaluation Statistics</h1>
        </div>
    </div>

    @if(auth()->user()->isAdmin() || auth()->user()->isManager())
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h5>Total Evaluations</h5>
                    <h2>{{ $stats['total_evaluations'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h5>Average Score</h5>
                    <h2>{{ number_format($stats['average_score'] ?? 0, 1) }}%</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h5>Excellent (90%+)</h5>
                    <h2>{{ $stats['excellent_count'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h5>Poor (&lt;60%)</h5>
                    <h2>{{ $stats['poor_count'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Score Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="scoreChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Performance Breakdown</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Level</th>
                                    <th>Count</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Excellent (90-100%)</td>
                                    <td>{{ $stats['excellent_count'] ?? 0 }}</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" style="width: {{ ($stats['excellent_count'] / max($stats['total_evaluations'], 1)) * 100 }}%">
                                                {{ number_format(($stats['excellent_count'] / max($stats['total_evaluations'], 1)) * 100, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Very Good (75-89%)</td>
                                    <td>{{ $stats['good_count'] ?? 0 }}</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-info" style="width: {{ ($stats['good_count'] / max($stats['total_evaluations'], 1)) * 100 }}%">
                                                {{ number_format(($stats['good_count'] / max($stats['total_evaluations'], 1)) * 100, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Satisfactory (60-74%)</td>
                                    <td>{{ $stats['satisfactory_count'] ?? 0 }}</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" style="width: {{ ($stats['satisfactory_count'] / max($stats['total_evaluations'], 1)) * 100 }}%">
                                                {{ number_format(($stats['satisfactory_count'] / max($stats['total_evaluations'], 1)) * 100, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Poor (&lt;60%)</td>
                                    <td>{{ $stats['poor_count'] ?? 0 }}</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" style="width: {{ ($stats['poor_count'] / max($stats['total_evaluations'], 1)) * 100 }}%">
                                                {{ number_format(($stats['poor_count'] / max($stats['total_evaluations'], 1)) * 100, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(isset($stats['top_employees']))
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Top Performers</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Employee</th>
                                    <th>Department</th>
                                    <th>Average Score</th>
                                    <th>Performance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['top_employees'] as $index => $employee)
                                <tr>
                                    <td>{{ $index + 1 }}</a></td>
                                    <td>{{ $employee->employee->getFullName() }}</a></td>
                                    <td>{{ $employee->employee->department->name ?? 'N/A' }}</a></td>
                                    <td>
                                        <span class="badge bg-{{ $employee->avg_score >= 90 ? 'success' : ($employee->avg_score >= 75 ? 'info' : 'warning') }}">
                                            {{ number_format($employee->avg_score, 1) }}%
                                        </span>
                                    </a>
                                    <td>{{ $employee->avg_score >= 90 ? 'Excellent' : ($employee->avg_score >= 75 ? 'Very Good' : 'Good') }}</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @else
    <!-- Employee View -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h5>My Evaluations</h5>
                    <h2>{{ $stats['my_evaluations'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h5>Average Score</h5>
                    <h2>{{ number_format($stats['my_average_score'] ?? 0, 1) }}%</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h5>Best Score</h5>
                    <h2>{{ number_format($stats['my_best_score'] ?? 0, 1) }}%</h2>
                </div>
            </div>
        </div>
    </div>

    @if(isset($stats['my_last_evaluation']) && $stats['my_last_evaluation'])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Latest Evaluation</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <h3>{{ number_format($stats['my_last_evaluation']->overall_score, 1) }}%</h3>
                        <p>{{ $stats['my_last_evaluation']->getPerformanceLevel() }}</p>
                        <div class="progress" style="height: 30px;">
                            <div class="progress-bar bg-{{ $stats['my_last_evaluation']->overall_score >= 75 ? 'success' : ($stats['my_last_evaluation']->overall_score >= 60 ? 'warning' : 'danger') }}" 
                                 style="width: {{ $stats['my_last_evaluation']->overall_score }}%">
                                {{ $stats['my_last_evaluation']->overall_score }}%
                            </div>
                        </div>
                        <p class="mt-3"><strong>Period:</strong> {{ $stats['my_last_evaluation']->period }}</p>
                        <p><strong>Date:</strong> {{ $stats['my_last_evaluation']->evaluation_date->format('d/m/Y') }}</p>
                        @if($stats['my_last_evaluation']->comments)
                        <div class="alert alert-info mt-3">
                            <strong>Feedback:</strong> {{ $stats['my_last_evaluation']->comments }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if(auth()->user()->isAdmin() || auth()->user()->isManager())
    const ctx = document.getElementById('scoreChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Excellent', 'Very Good', 'Satisfactory', 'Poor'],
            datasets: [{
                label: 'Number of Evaluations',
                data: [
                    {{ $stats['excellent_count'] ?? 0 }},
                    {{ $stats['good_count'] ?? 0 }},
                    {{ $stats['satisfactory_count'] ?? 0 }},
                    {{ $stats['poor_count'] ?? 0 }}
                ],
                backgroundColor: [
                    '#28a745',
                    '#17a2b8',
                    '#ffc107',
                    '#dc3545'
                ],
                borderWidth: 1
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
    @endif
</script>
@endpush