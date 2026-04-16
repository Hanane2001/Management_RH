@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Departments Management</h1>
    
    @can('create', App\Models\Department::class)
    <div class="mb-3">
        <a href="{{ route('departments.create') }}" class="btn btn-primary">+ Add New Department</a>
    </div>
    @endcan
    
    <div class="row">
        @forelse($departments as $department)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5>{{ $department->name }}</h5>
                </div>
                <div class="card-body">
                    <p>{{ $department->description ?? 'No description' }}</p>
                    <p><strong>Manager:</strong> {{ $department->manager->first_name ?? 'N/A' }} {{ $department->manager->last_name ?? '' }}</p>
                    <p><strong>Employees:</strong> {{ $department->employees->count() }}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('departments.show', $department->id) }}" class="btn btn-sm btn-info">View</a>
                    @can('update', $department)
                        <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    @endcan
                    @can('delete', $department)
                        <form action="{{ route('departments.destroy', $department->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this department?')">Delete</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">No departments found</div>
        </div>
        @endforelse
    </div>
</div>
@endsection