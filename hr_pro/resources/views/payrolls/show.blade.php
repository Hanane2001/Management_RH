@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Payroll Details</h1>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Payroll Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Employee:</strong> {{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</p>
                            <p><strong>Department:</strong> {{ $payroll->employee->department->name ?? 'N/A' }}</p>
                            <p><strong>Period:</strong> {{ $payroll->getMonthName() }} {{ $payroll->year }}</p>
                            <p><strong>Status:</strong> {!! $payroll->getStatusBadge() !!}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Created:</strong> {{ $payroll->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Last Update:</strong> {{ $payroll->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4>Total</h4>
                </div>
                <div class="card-body text-center">
                    <h2>{{ number_format($payroll->net_pay, 2) }} DH</h2>
                    <a href="{{ route('payrolls.pdf', $payroll) }}" class="btn btn-primary mt-2">Download PDF</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-header bg-info text-white">
            <h4>Salary Details</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="50%">Base Salary</th>
                    <td>{{ number_format($payroll->base_salary, 2) }} DH</td>
                </tr>
                <tr>
                    <th>Overtime Hours</th>
                    <td>{{ $payroll->overtime_hours }} hours</td>
                </tr>
                <tr>
                    <th>Bonuses</th>
                    <td>{{ number_format($payroll->bonuses, 2) }} DH</td>
                </tr>
                <tr>
                    <th>Allowances</th>
                    <td>{{ number_format($payroll->allowances, 2) }} DH</td>
                </tr>
                <tr class="table-success">
                    <th>Total Earnings</th>
                    <td>{{ number_format($payroll->base_salary + $payroll->bonuses + $payroll->allowances, 2) }} DH</td>
                </tr>
                <tr>
                    <th>Deductions</th>
                    <td>{{ number_format($payroll->deductions, 2) }} DH</td>
                </tr>
                <tr class="table-primary">
                    <th><strong>Net Pay</strong></th>
                    <td><strong>{{ number_format($payroll->net_pay, 2) }} DH</strong></td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="mt-3">
        <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">Back</a>
        @can('update', $payroll)
            <a href="{{ route('payrolls.edit', $payroll) }}" class="btn btn-warning">Edit</a>
        @endcan
        @if($payroll->canBeApproved())
            <form action="{{ route('payrolls.approve', $payroll) }}" method="POST" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-success">Approve</button>
            </form>
        @endif
        @if($payroll->canBePaid())
            <form action="{{ route('payrolls.mark-paid', $payroll) }}" method="POST" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-primary">Mark as Paid</button>
            </form>
        @endif
        @can('delete', $payroll)
            <form action="{{ route('payrolls.destroy', $payroll) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this payroll?')">Delete</button>
            </form>
        @endcan
    </div>
</div>
@endsection