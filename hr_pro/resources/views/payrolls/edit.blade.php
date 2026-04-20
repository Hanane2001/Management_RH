@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Payroll</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('payrolls.update', $payroll) }}">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label>Employee</label>
                    <select name="employee_id" class="form-control" required>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id', $payroll->employee_id) == $employee->id ? 'selected' : '' }}>
                                {{ $employee->first_name }} {{ $employee->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Month</label>
                        <select name="month" class="form-control" required>
                            @foreach($months as $key => $monthName)
                                <option value="{{ $key }}" {{ old('month', $payroll->month) == $key ? 'selected' : '' }}>
                                    {{ $monthName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Year</label>
                        <select name="year" class="form-control" required>
                            @foreach($years as $yearValue)
                                <option value="{{ $yearValue }}" {{ old('year', $payroll->year) == $yearValue ? 'selected' : '' }}>
                                    {{ $yearValue }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label>Base Salary</label>
                    <input type="number" step="0.01" name="base_salary" class="form-control" value="{{ old('base_salary', $payroll->base_salary) }}" required>
                </div>
                
                <div class="mb-3">
                    <label>Overtime Hours</label>
                    <input type="number" name="overtime_hours" class="form-control" value="{{ old('overtime_hours', $payroll->overtime_hours) }}">
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Bonuses</label>
                        <input type="number" step="0.01" name="bonuses" class="form-control" value="{{ old('bonuses', $payroll->bonuses) }}">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Allowances</label>
                        <input type="number" step="0.01" name="allowances" class="form-control" value="{{ old('allowances', $payroll->allowances) }}">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label>Deductions</label>
                    <input type="number" step="0.01" name="deductions" class="form-control" value="{{ old('deductions', $payroll->deductions) }}">
                </div>
                
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="draft" {{ old('status', $payroll->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="generated" {{ old('status', $payroll->status) == 'generated' ? 'selected' : '' }}>Generated</option>
                        <option value="approved" {{ old('status', $payroll->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="paid" {{ old('status', $payroll->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>
                
                <div class="alert alert-info">
                    <strong>Net Pay:</strong> {{ number_format($payroll->net_pay, 2) }} DH
                    <small>(Will be recalculated automatically)</small>
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Update Payroll</button>
                    <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection