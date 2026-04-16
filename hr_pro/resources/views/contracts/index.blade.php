@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Contracts Management</h1>
    
    @can('create', App\Models\Contract::class)
    <div class="mb-3">
        <a href="{{ route('contracts.create') }}" class="btn btn-primary">+ New Contract</a>
    </div>
    @endcan
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Type</th>
                            <th>Position</th>
                            <th>Salary</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contracts as $contract)
                        <tr>
                            <td>{{ $contract->employee->first_name }} {{ $contract->employee->last_name }}</td>
                            <td>{{ ucfirst($contract->type) }}</td>
                            <td>{{ $contract->position }}</td>
                            <td>{{ number_format($contract->base_salary, 2) }} DH</td>
                            <td>{{ $contract->start_date->format('d/m/Y') }}</td>
                            <td>{{ $contract->end_date ? $contract->end_date->format('d/m/Y') : 'Permanent' }}</td>
                            <td>
                                @if($contract->isActive())
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Expired</span>
                                @endif
                             </td>
                            <td>
                                <a href="{{ route('contracts.show', $contract->id) }}" class="btn btn-sm btn-info">View</a>
                                @can('update', $contract)
                                    <a href="{{ route('contracts.edit', $contract->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                @endcan
                                @can('delete', $contract)
                                    <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this contract?')">Delete</button>
                                    </form>
                                @endcan
                             </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No contracts found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection