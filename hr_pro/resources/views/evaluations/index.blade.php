@extends('layouts.app')

@section('title', 'Evaluations')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Performance Evaluations</h3>
                    @can('create', App\Models\Evaluation::class)
                    <a href="{{ route('evaluations.create') }}" class="btn btn-primary float-end">
                        <i class="fas fa-plus"></i> New Evaluation
                    </a>
                    @endcan
                    <a href="{{ route('evaluations.statistics') }}" class="btn btn-info float-end me-2">
                        <i class="fas fa-chart-bar"></i> Statistics
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Employee</th>
                                    <th>Evaluator</th>
                                    <th>Date</th>
                                    <th>Period</th>
                                    <th>Score</th>
                                    <th>Performance</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($evaluations as $evaluation)
                                <tr>
                                    <td>{{ $evaluation->id }}</a></td>
                                    <td><a href="{{ route('employees.show', $evaluation->employee_id) }}">
                                        {{ $evaluation->employee->getFullName() }}
                                    </a></td>
                                    <td>{{ $evaluation->evaluator->getFullName() }}</a></td>
                                    <td>{{ $evaluation->evaluation_date->format('d/m/Y') }}</a></td>
                                    <td>{{ $evaluation->period }}</a></td>
                                    <td>
                                        <span class="badge bg-{{ $evaluation->overall_score >= 75 ? 'success' : ($evaluation->overall_score >= 60 ? 'warning' : 'danger') }}">
                                            {{ $evaluation->overall_score }}%
                                        </span>
                                    </a>
                                    <td>{{ $evaluation->getPerformanceLevel() }}</a></td>
                                    <td>
                                        <a href="{{ route('evaluations.show', $evaluation) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('update', $evaluation)
                                        <a href="{{ route('evaluations.edit', $evaluation) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('delete', $evaluation)
                                        <form method="POST" action="{{ route('evaluations.destroy', $evaluation) }}" class="d-inline" 
                                              onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </a>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $evaluations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection