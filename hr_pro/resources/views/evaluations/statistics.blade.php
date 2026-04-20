@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Statistiques des évaluations</h1>
    
    @if(auth()->user()->isAdmin() || auth()->user()->isManager())
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5>Total évaluations</h5>
                        <h2>{{ $stats['total_evaluations'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5>Score moyen</h5>
                        <h2>{{ number_format($stats['average_score'], 1) }}%</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5>Excellent (≥90%)</h5>
                        <h2>{{ $stats['excellent_count'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5>Insuffisant (&lt;60%)</h5>
                        <h2>{{ $stats['poor_count'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Distribution des scores</div>
                    <div class="card-body">
                        <canvas id="distributionChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Top 10 employés</div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($stats['top_employees'] ?? [] as $top)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $top->employee->first_name }} {{ $top->employee->last_name }}
                                    <span class="badge bg-success rounded-pill">{{ number_format($top->avg_score, 1) }}%</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Employee statistics -->
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5>Mes évaluations</h5>
                        <h2>{{ $stats['my_evaluations'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5>Score moyen</h5>
                        <h2>{{ number_format($stats['my_average_score'], 1) }}%</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5>Meilleur score</h5>
                        <h2>{{ number_format($stats['my_best_score'], 1) }}%</h2>
                    </div>
                </div>
            </div>
        </div>
        
        @if($stats['my_last_evaluation'])
            <div class="card mt-4">
                <div class="card-header">Dernière évaluation</div>
                <div class="card-body">
                    <p><strong>Date:</strong> {{ $stats['my_last_evaluation']->evaluation_date->format('d/m/Y') }}</p>
                    <p><strong>Score:</strong> {{ $stats['my_last_evaluation']->overall_score }}%</p>
                    <p><strong>Commentaires:</strong> {{ $stats['my_last_evaluation']->comments ?? 'Aucun' }}</p>
                </div>
            </div>
        @endif
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if(auth()->user()->isAdmin() || auth()->user()->isManager())
    new Chart(document.getElementById('distributionChart'), {
        type: 'bar',
        data: {
            labels: ['Excellent', 'Très bien', 'Satisfaisant', 'Insuffisant'],
            datasets: [{
                label: 'Nombre d\'évaluations',
                data: [
                    {{ $stats['excellent_count'] }},
                    {{ $stats['good_count'] }},
                    {{ $stats['satisfactory_count'] }},
                    {{ $stats['poor_count'] }}
                ],
                backgroundColor: ['#10B981', '#3B82F6', '#F59E0B', '#EF4444']
            }]
        }
    });
    @endif
</script>
@endpush
@endsection