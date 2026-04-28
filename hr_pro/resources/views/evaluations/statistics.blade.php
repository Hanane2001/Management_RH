@extends('layouts.app')

@section('title', 'Evaluation Statistics')

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
    
    .stat-icon.blue { background: #EFF6FF; color: #1D4ED8; }
    .stat-icon.teal { background: #F0FDF4; color: #10B981; }
    .stat-icon.orange { background: #FFF7ED; color: #F97316; }
    .stat-icon.red { background: #FEF2F2; color: #EF4444; }
    
    .stat-value {
        font-family: 'Inter', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 5px;
    }
    
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
    
    .progress {
        height: 8px;
        background: #E5E7EB;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .progress-bar {
        height: 100%;
        border-radius: 10px;
    }
    
    .rank-number {
        display: inline-block;
        width: 30px;
        height: 30px;
        background: #F3F4F6;
        border-radius: 10px;
        text-align: center;
        line-height: 30px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .rank-1 { background: #FEF3C7; color: #D97706; }
    .rank-2 { background: #E5E7EB; color: #6B7280; }
    .rank-3 { background: #FEE2E2; color: #DC2626; }
    
    .chart-container {
        max-width: 400px;
        margin: 0 auto;
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
</style>

<div class="container-fluid">
    <div class="page-header">
        <h1 class="page-title">Evaluation Statistics</h1>
        <p class="page-subtitle">Performance overview and analytics</p>
    </div>
    
    @if(auth()->user()->isAdmin() || auth()->user()->isManager())
    <!-- Admin/Manager View -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Total Evaluations</span>
                <div class="stat-icon blue"><i class="fas fa-chart-line"></i></div>
            </div>
            <div class="stat-value">{{ $stats['total_evaluations'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Average Score</span>
                <div class="stat-icon teal"><i class="fas fa-percent"></i></div>
            </div>
            <div class="stat-value">{{ number_format($stats['average_score'] ?? 0, 1) }}%</div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Excellent (90%+)</span>
                <div class="stat-icon orange"><i class="fas fa-trophy"></i></div>
            </div>
            <div class="stat-value">{{ $stats['excellent_count'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Poor (&lt;60%)</span>
                <div class="stat-icon red"><i class="fas fa-exclamation-triangle"></i></div>
            </div>
            <div class="stat-value">{{ $stats['poor_count'] ?? 0 }}</div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="data-card">
                <div class="card-header-custom">
                    <h5><i class="fas fa-chart-pie"></i> Score Distribution</h5>
                </div>
                <div class="card-body-custom">
                    <div class="chart-container">
                        <canvas id="scoreChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-7 mb-4">
            <div class="data-card">
                <div class="card-header-custom">
                    <h5><i class="fas fa-chart-bar"></i> Performance Breakdown</h5>
                </div>
                <div class="card-body-custom">
                    <div class="table-responsive">
                        <table class="table-modern">
                            <thead>
                                <tr>
                                    <th>Level</th>
                                    <th>Count</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge-score badge-excellent">Excellent (90-100%)</span></td>
                                    <td>{{ $stats['excellent_count'] ?? 0 }}</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" style="width: {{ ($stats['excellent_count'] / max($stats['total_evaluations'], 1)) * 100 }}%"></div>
                                        </div>
                                        <small>{{ number_format(($stats['excellent_count'] / max($stats['total_evaluations'], 1)) * 100, 1) }}%</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="badge-score badge-very-good">Very Good (75-89%)</span></td>
                                    <td>{{ $stats['good_count'] ?? 0 }}</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-info" style="width: {{ ($stats['good_count'] / max($stats['total_evaluations'], 1)) * 100 }}%"></div>
                                        </div>
                                        <small>{{ number_format(($stats['good_count'] / max($stats['total_evaluations'], 1)) * 100, 1) }}%</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="badge-score badge-satisfactory">Satisfactory (60-74%)</span></td>
                                    <td>{{ $stats['satisfactory_count'] ?? 0 }}</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" style="width: {{ ($stats['satisfactory_count'] / max($stats['total_evaluations'], 1)) * 100 }}%"></div>
                                        </div>
                                        <small>{{ number_format(($stats['satisfactory_count'] / max($stats['total_evaluations'], 1)) * 100, 1) }}%</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="badge-score badge-insufficient">Poor (&lt;60%)</span></td>
                                    <td>{{ $stats['poor_count'] ?? 0 }}</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" style="width: {{ ($stats['poor_count'] / max($stats['total_evaluations'], 1)) * 100 }}%"></div>
                                        </div>
                                        <small>{{ number_format(($stats['poor_count'] / max($stats['total_evaluations'], 1)) * 100, 1) }}%</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if(isset($stats['top_employees']) && $stats['top_employees']->count() > 0)
    <div class="row">
        <div class="col-12 mb-4">
            <div class="data-card">
                <div class="card-header-custom">
                    <h5><i class="fas fa-trophy"></i> Top Performers</h5>
                </div>
                <div class="card-body-custom" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="table-modern">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">Rank</th>
                                    <th>Employee</th>
                                    <th>Department</th>
                                    <th>Average Score</th>
                                    <th>Performance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['top_employees'] as $index => $employee)
                                <tr>
                                    <td>
                                        <span class="rank-number 
                                            @if($index == 0) rank-1
                                            @elseif($index == 1) rank-2
                                            @elseif($index == 2) rank-3 @endif">
                                            {{ $index + 1 }}
                                        </span>
                                    </td>
                                    <td><strong>{{ $employee->employee->getFullName() }}</strong></td>
                                    <td>{{ $employee->employee->department->name ?? '—' }}</td>
                                    <td>
                                        <span class="badge-score 
                                            @if($employee->avg_score >= 90) badge-excellent
                                            @elseif($employee->avg_score >= 75) badge-very-good
                                            @else badge-satisfactory @endif">
                                            {{ number_format($employee->avg_score, 1) }}%
                                        </span>
                                    </td>
                                    <td>
                                        <div class="progress" style="width: 100px;">
                                            <div class="progress-bar 
                                                @if($employee->avg_score >= 90) bg-success
                                                @elseif($employee->avg_score >= 75) bg-info
                                                @else bg-warning @endif" 
                                                style="width: {{ $employee->avg_score }}%">
                                            </div>
                                        </div>
                                    </td>
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
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">My Evaluations</span>
                <div class="stat-icon blue"><i class="fas fa-star"></i></div>
            </div>
            <div class="stat-value">{{ $stats['my_evaluations'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Average Score</span>
                <div class="stat-icon teal"><i class="fas fa-chart-line"></i></div>
            </div>
            <div class="stat-value">{{ number_format($stats['my_average_score'] ?? 0, 1) }}%</div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Best Score</span>
                <div class="stat-icon orange"><i class="fas fa-trophy"></i></div>
            </div>
            <div class="stat-value">{{ number_format($stats['my_best_score'] ?? 0, 1) }}%</div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Evaluations</span>
                <div class="stat-icon red"><i class="fas fa-clipboard-list"></i></div>
            </div>
            <div class="stat-value">{{ $stats['my_evaluations'] }}</div>
        </div>
    </div>
    
    @if(isset($stats['my_last_evaluation']) && $stats['my_last_evaluation'])
    <div class="row">
        <div class="col-12">
            <div class="data-card">
                <div class="card-header-custom">
                    <h5><i class="fas fa-clock"></i> Latest Evaluation</h5>
                </div>
                <div class="card-body-custom">
                    <div class="text-center">
                        <div class="score-value 
                            @if($stats['my_last_evaluation']->overall_score >= 90) excellent
                            @elseif($stats['my_last_evaluation']->overall_score >= 75) very-good
                            @elseif($stats['my_last_evaluation']->overall_score >= 60) satisfactory
                            @else insufficient @endif"
                            style="font-size: 2.5rem;">
                            {{ number_format($stats['my_last_evaluation']->overall_score, 1) }}%
                        </div>
                        <div class="progress-custom" style="max-width: 300px; margin: 15px auto;">
                            <div class="progress-bar-custom 
                                @if($stats['my_last_evaluation']->overall_score >= 90) excellent
                                @elseif($stats['my_last_evaluation']->overall_score >= 75) very-good
                                @elseif($stats['my_last_evaluation']->overall_score >= 60) satisfactory
                                @else insufficient @endif" 
                                style="width: {{ $stats['my_last_evaluation']->overall_score }}%; height: 10px;">
                            </div>
                        </div>
                        <p><strong>Period:</strong> {{ $stats['my_last_evaluation']->period }}</p>
                        <p><strong>Date:</strong> {{ $stats['my_last_evaluation']->evaluation_date->format('d/m/Y') }}</p>
                        @if($stats['my_last_evaluation']->comments)
                        <div class="info-section" style="margin-top: 20px; text-align: left;">
                            <strong><i class="fas fa-comment"></i> Feedback:</strong>
                            <p style="margin-top: 10px;">{{ $stats['my_last_evaluation']->comments }}</p>
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
        type: 'doughnut',
        data: {
            labels: ['Excellent (90-100%)', 'Very Good (75-89%)', 'Satisfactory (60-74%)', 'Poor (<60%)'],
            datasets: [{
                data: [
                    {{ $stats['excellent_count'] ?? 0 }},
                    {{ $stats['good_count'] ?? 0 }},
                    {{ $stats['satisfactory_count'] ?? 0 }},
                    {{ $stats['poor_count'] ?? 0 }}
                ],
                backgroundColor: ['#10B981', '#3B82F6', '#F59E0B', '#EF4444'],
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
                        font: { family: 'Inter, sans-serif', size: 11 },
                        padding: 10
                    }
                }
            },
            cutout: '60%'
        }
    });
    @endif
</script>
@endpush