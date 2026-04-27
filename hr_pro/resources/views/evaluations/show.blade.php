@extends('layouts.app')

@section('title', 'Evaluation Details')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Evaluation Details</h3>
                    <a href="{{ route('evaluations.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Employee</th>
                                    <td>{{ $evaluation->employee->getFullName() }}</a>
                                </a>
                                <tr>
                                    <th>Department</th>
                                    <td>{{ $evaluation->employee->department->name ?? 'N/A' }}</a>
                                </a>
                                <tr>
                                    <th>Evaluator</th>
                                    <td>{{ $evaluation->evaluator->getFullName() }}</a>
                                </a>
                                <tr>
                                                                    
                                <tr>
                                    <th>Evaluation Date</th>
                                    <td>{{ $evaluation->evaluation_date->format('d/m/Y') }} </a>
                                </a>
                                <tr>
                                    <th>Period</th>
                                    <td>{{ $evaluation->period }} </a>
                                </a>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Overall Score</th>
                                    <td>
                                        <h2 class="text-{{ $evaluation->overall_score >= 75 ? 'success' : ($evaluation->overall_score >= 60 ? 'warning' : 'danger') }}">
                                            {{ $evaluation->overall_score }}%
                                        </h2>
                                    </a>
                                </a>
                                <tr>
                                    <th>Performance Level</th>
                                    <td>
                                        <span class="badge bg-{{ $evaluation->overall_score >= 90 ? 'success' : ($evaluation->overall_score >= 75 ? 'info' : ($evaluation->overall_score >= 60 ? 'warning' : 'danger')) }} badge-lg">
                                            {{ $evaluation->getPerformanceLevel() }}
                                        </span>
                                    </a>
                                </a>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h5>Comments & Feedback</h5>
                        <div class="card bg-light">
                            <div class="card-body">
                                {{ $evaluation->comments ?? 'No comments provided.' }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <div class="progress" style="height: 30px;">
                            <div class="progress-bar bg-{{ $evaluation->overall_score >= 75 ? 'success' : ($evaluation->overall_score >= 60 ? 'warning' : 'danger') }}" 
                                 style="width: {{ $evaluation->overall_score }}%">
                                {{ $evaluation->overall_score }}% - {{ $evaluation->getPerformanceLevel() }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        @can('update', $evaluation)
                        <a href="{{ route('evaluations.edit', $evaluation) }}" class="btn btn-warning">Edit Evaluation</a>
                        @endcan
                        @can('delete', $evaluation)
                        <form method="POST" action="{{ route('evaluations.destroy', $evaluation) }}" class="d-inline" 
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete Evaluation</button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection