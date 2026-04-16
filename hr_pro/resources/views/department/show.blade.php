@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Department Details</h1>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4>{{ $department->name }}</h4>
                </div>
                <div class="card-body">
                    <p><strong>Description:</strong> {{ $department->description ?? 'No description' }}</p>
                    <p><strong>Manager:</strong> {{ $department->manager->first_name ?? 'N/A' }} {{ $department->manager->last_name ?? '' }}</p>
                    <p><strong>Created at:</strong> {{ $department->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Last update:</strong> {{ $department->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4>Employees ({{ $department->employees->count() }})</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse($department->employees as $employee)
                            <li class="list-group-item">
                                {{ $employee->first_name }} {{ $employee->last_name }}
                                <span class="badge bg-secondary">{{ $employee->email }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">No employees in this department</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        <a href="{{ route('departments.index') }}" class="btn btn-secondary">Back to List</a>
        @can('update', $department)
            <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-warning">Edit</a>
        @endcan
    </div>
</div>
@endsection