@extends('layouts.app')

@section('title', 'Departments')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Departments Management</h3>
                    @can('create', App\Models\Department::class)
                    <a href="{{ route('departments.create') }}" class="btn btn-primary float-end">
                        <i class="fas fa-plus"></i> Add Department
                    </a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Manager</th>
                                    <th>Employees Count</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($departments as $department)
                                <tr>
                                    <td>{{ $department->id }}</td>
                                    <td>{{ $department->name }}</a></td>
                                    <td>{{ $department->manager ? $department->manager->getFullName() : 'Not Assigned' }}</a></td>
                                    <td>{{ $department->getEmployeeCount() }} employees</a></td>
                                    <td>
                                        <a href="{{ route('departments.show', $department->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('update', $department)
                                        <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('delete', $department)
                                        <form method="POST" action="{{ route('departments.destroy', $department->id) }}" class="d-inline" 
                                              onsubmit="return confirm('Are you sure? This will affect all employees in this department.')">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection