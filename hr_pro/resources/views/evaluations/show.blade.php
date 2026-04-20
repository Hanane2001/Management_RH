@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Détail de l'évaluation</h1>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4>Informations générales</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Employé évalué:</strong> {{ $evaluation->employee->first_name }} {{ $evaluation->employee->last_name }}</p>
                            <p><strong>Évaluateur:</strong> {{ $evaluation->evaluator->first_name }} {{ $evaluation->evaluator->last_name }}</p>
                            <p><strong>Date d'évaluation:</strong> {{ $evaluation->evaluation_date->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Période:</strong> {{ $evaluation->period }}</p>
                            <p><strong>Score:</strong> {{ $evaluation->overall_score }}%</p>
                            <p><strong>Performance:</strong> {!! $evaluation->getScoreBadge() !!}</p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h5>Commentaires</h5>
                    <p>{{ $evaluation->comments ?? 'Aucun commentaire' }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4>Analyse du score</h4>
                </div>
                <div class="card-body text-center">
                    <div style="position: relative; width: 200px; height: 200px; margin: 0 auto;">
                        <canvas id="scoreChart"></canvas>
                    </div>
                    <h3 class="mt-3">{{ $evaluation->overall_score }}%</h3>
                    <p class="text-muted">{{ $evaluation->getPerformanceLevel() }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        <a href="{{ route('evaluations.index') }}" class="btn btn-secondary">Retour</a>
        @can('update', $evaluation)
            <a href="{{ route('evaluations.edit', $evaluation) }}" class="btn btn-warning">Modifier</a>
        @endcan
        @can('delete', $evaluation)
            <form action="{{ route('evaluations.destroy', $evaluation) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer cette évaluation ?')">Supprimer</button>
            </form>
        @endcan
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('scoreChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Score', 'Restant'],
            datasets: [{
                data: [{{ $evaluation->overall_score }}, 100 - {{ $evaluation->overall_score }}],
                backgroundColor: ['#10B981', '#E5E7EB'],
                borderWidth: 0
            }]
        },
        options: {
            cutout: '70%',
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endpush
@endsection