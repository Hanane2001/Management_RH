@extends('layouts.app')

@section('title', 'Department Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Department Information</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Name</th>
                            <td>{{ $department->name }}</td>
                        </tr>
                        <tr>
                            <th>Manager</th>
                            <td>{{ $department->manager ? $department->manager->getFullName() : 'Not Assigned' }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ $department->description ?? 'No description' }}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $department->created_at->format('d/m/Y') }}</td>
                        </tr>
                    </table>
                    <div class="d-grid gap-2">
                        <a href="{{ route('departments.index') }}" class="btn btn-secondary">Back</a>
                        @can('update', $department)
                        <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-warning">Edit Department</a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Employees in {{ $department->name }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Position</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($department->employees as $employee)
                                <tr>
                                    <td>{{ $employee->id }}</a></td>
                                    <td>{{ $employee->getFullName() }}</a></a></td>
                                    <td>{{ $employee->email }}</a></a></td>
                                    <td>{{ $employee->contracts->first()->position ?? 'N/A' }}</a></a></td>
                                    <td>
                                        <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </a>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No employees in this department</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection