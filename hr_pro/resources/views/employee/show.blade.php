@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Employee Details</h1>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4>Personal Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Full Name:</strong> {{ $employee->first_name }} {{ $employee->last_name }}</p>
                            <p><strong>Email:</strong> {{ $employee->email }}</p>
                            <p><strong>Phone:</strong> {{ $employee->phone ?? 'N/A' }}</p>
                            <p><strong>Birth Date:</strong> {{ $employee->birth_date ? $employee->birth_date->format('d/m/Y') : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Department:</strong> {{ $employee->department->name ?? 'N/A' }}</p>
                            <p><strong>Role:</strong> {{ $employee->role->name ?? 'N/A' }}</p>
                            <p><strong>ID Number:</strong> {{ $employee->id_number ?? 'N/A' }}</p>
                            <p><strong>Social Security:</strong> {{ $employee->social_security_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <p><strong>Address:</strong> {{ $employee->address ?? 'N/A' }}</p>
                    <p><strong>Status:</strong> 
                        @if($employee->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h4>Statistics</h4>
                </div>
                <div class="card-body">
                    <p><strong>Active Contract:</strong> 
                        @if($activeContract)
                            <span class="badge bg-success">Yes</span>
                        @else
                            <span class="badge bg-danger">No</span>
                        @endif
                    </p>
                    <p><strong>Total Leaves:</strong> {{ $totalLeaves }}</p>
                    <p><strong>Pending Leaves:</strong> {{ $pendingLeaves }}</p>
                    <p><strong>Approved Leaves:</strong> {{ $approvedLeaves }}</p>
                    <p><strong>Leave Balance:</strong> {{ $currentBalance ? $currentBalance->remaining_days : 0 }} days</p>
                </div>
            </div>
        </div>
    </div>
    
    @if($activeContract)
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h4>Active Contract</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <p><strong>Position:</strong> {{ $activeContract->position }}</p>
                </div>
                <div class="col-md-3">
                    <p><strong>Type:</strong> {{ $activeContract->type }}</p>
                </div>
                <div class="col-md-3">
                    <p><strong>Base Salary:</strong> {{ number_format($activeContract->base_salary, 2) }} DH</p>
                </div>
                <div class="col-md-3">
                    <p><strong>Start Date:</strong> {{ $activeContract->start_date->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <div class="mt-3">
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back to List</a>
        @can('update', $employee)
            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning">Edit</a>
        @endcan
        @can('delete', $employee)
            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this employee?')">Delete</button>
            </form>
        @endcan
    </div>
</div>
@endsection