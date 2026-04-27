@extends('layouts.app')

@section('title', 'Contracts')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Contracts Management</h3>
                    @can('create', App\Models\Contract::class)
                    <a href="{{ route('contracts.create') }}" class="btn btn-primary float-end">
                        <i class="fas fa-plus"></i> Add Contract
                    </a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Employee</th>
                                    <th>Position</th>
                                    <th>Type</th>
                                    <th>Base Salary</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contracts as $contract)
                                <tr>
                                    <td>{{ $contract->id }}</a></td>
                                    <td><a href="{{ route('employees.show', $contract->employee_id) }}">
                                        {{ $contract->employee->getFullName() }}
                                    </a></td>
                                    <td>{{ $contract->position }}</a></td>
                                    <td>{{ ucfirst($contract->type) }}</a></td>
                                    <td>{{ number_format($contract->base_salary, 2) }} DH</a></td>
                                    <td>{{ $contract->start_date->format('d/m/Y') }}</a></td>
                                    <td>{{ $contract->end_date ? $contract->end_date->format('d/m/Y') : 'Current' }}</a></td>
                                    <td>
                                        @if($contract->isActive())
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Expired</span>
                                        @endif
                                    </a>
                                    <td>
                                        <a href="{{ route('contracts.show', $contract) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('update', $contract)
                                        <a href="{{ route('contracts.edit', $contract) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('delete', $contract)
                                        <form method="POST" action="{{ route('contracts.destroy', $contract) }}" class="d-inline" 
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection