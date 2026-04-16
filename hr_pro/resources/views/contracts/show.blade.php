@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Contract Details</h1>
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Employee:</strong> {{ $contract->employee->first_name }} {{ $contract->employee->last_name }}</p>
                    <p><strong>Type:</strong> {{ ucfirst($contract->type) }}</p>
                    <p><strong>Position:</strong> {{ $contract->position }}</p>
                    <p><strong>Base Salary:</strong> {{ number_format($contract->base_salary, 2) }} DH</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Bonus:</strong> {{ number_format($contract->bonus, 2) }} DH</p>
                    <p><strong>Total Salary:</strong> {{ number_format($contract->base_salary + $contract->bonus, 2) }} DH</p>
                    <p><strong>Start Date:</strong> {{ $contract->start_date->format('d/m/Y') }}</p>
                    <p><strong>End Date:</strong> {{ $contract->end_date ? $contract->end_date->format('d/m/Y') : 'Permanent' }}</p>
                </div>
            </div>
            
            <p><strong>Status:</strong> 
                @if($contract->isActive())
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Expired</span>
                @endif
            </p>
            
            @if($contract->document_path)
                <p><strong>Document:</strong> 
                    <a href="{{ asset('storage/'.$contract->document_path) }}" target="_blank" class="btn btn-sm btn-info">View Document</a>
                </p>
            @endif
        </div>
    </div>
    
    <div class="mt-3">
        <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Back to List</a>
        @can('update', $contract)
            <a href="{{ route('contracts.edit', $contract->id) }}" class="btn btn-warning">Edit</a>
        @endcan
    </div>
</div>
@endsection