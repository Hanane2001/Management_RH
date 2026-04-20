@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Évaluations</h1>
    
    <div class="mb-3">
        @can('create', App\Models\Evaluation::class)
            <a href="{{ route('evaluations.create') }}" class="btn btn-primary">+ Nouvelle évaluation</a>
        @endcan
        @can('viewAny', App\Models\Evaluation::class)
            <a href="{{ route('evaluations.statistics') }}" class="btn btn-info">Statistiques</a>
            <a href="{{ route('evaluations.export') }}" class="btn btn-success">Exporter CSV</a>
        @endcan
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Employé</th>
                            <th>Évaluateur</th>
                            <th>Date</th>
                            <th>Période</th>
                            <th>Score</th>
                            <th>Performance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($evaluations as $evaluation)
                        <tr>
                            <td>{{ $evaluation->employee->first_name }} {{ $evaluation->employee->last_name }}</td>
                            <td>{{ $evaluation->evaluator->first_name }} {{ $evaluation->evaluator->last_name }}</td>
                            <td>{{ $evaluation->evaluation_date->format('d/m/Y') }}</td>
                            <td>{{ $evaluation->period }}</td>
                            <td>{{ $evaluation->overall_score }}%</td>
                            <td>{!! $evaluation->getScoreBadge() !!}</td>
                            <td>
                                <a href="{{ route('evaluations.show', $evaluation) }}" class="btn btn-sm btn-info">Voir</a>
                                @can('update', $evaluation)
                                    <a href="{{ route('evaluations.edit', $evaluation) }}" class="btn btn-sm btn-warning">Modifier</a>
                                @endcan
                                @can('delete', $evaluation)
                                    <form action="{{ route('evaluations.destroy', $evaluation) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette évaluation ?')">Supprimer</button>
                                    </form>
                                @endcan
                              </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Aucune évaluation trouvée</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $evaluations->links() }}
        </div>
    </div>
</div>
@endsection