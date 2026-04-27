@extends('layouts.app')

@section('title', 'Contract Details')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Contract Details</h3>
                    <a href="{{ route('contracts.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Employee</th>
                                    <td>{{ $contract->employee->getFullName() }}</td>
                                </tr>
                                <tr>
                                    <th>Position</th>
                                    <td>{{ $contract->position }}</td>
                                </tr>
                                <tr>
                                    <th>Contract Type</th>
                                    <td>{{ ucfirst($contract->type) }}</td>
                                </tr>
                                <tr>
                                    <th>Base Salary</th>
                                    <td>{{ number_format($contract->base_salary, 2) }} DH</td>
                                </tr>
                                <tr>
                                    <th>Bonus</th>
                                    <td>{{ number_format($contract->bonus, 2) }} DH</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Start Date</th>
                                    <td>{{ $contract->start_date->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>End Date</th>
                                    <td>{{ $contract->end_date ? $contract->end_date->format('d/m/Y') : 'Current' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($contract->isActive())
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Expired</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total Package</th>
                                    <td><strong>{{ number_format($contract->getTotalSalary(), 2) }} DH</strong></td>
                                </tr>
                                <tr>
                                    <th>Document</th>
                                    <td>
                                        @if($contract->document_path)
                                            <a href="{{ asset('storage/' . $contract->document_path) }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        @else
                                            No document uploaded
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        @can('update', $contract)
                        <a href="{{ route('contracts.edit', $contract) }}" class="btn btn-warning">Edit Contract</a>
                        @endcan
                        @can('delete', $contract)
                        <form method="POST" action="{{ route('contracts.destroy', $contract) }}" class="d-inline" 
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete Contract</button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection