@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Create Payroll</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('payrolls.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label>Employee *</label>
                            <select name="employee_id" class="form-control" required>
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Month *</label>
                                <select name="month" class="form-control" required>
                                    @foreach($months as $key => $monthName)
                                        <option value="{{ $key }}" {{ old('month') == $key ? 'selected' : '' }}>
                                            {{ $monthName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label>Year *</label>
                                <select name="year" class="form-control" required>
                                    @foreach($years as $yearValue)
                                        <option value="{{ $yearValue }}" {{ old('year') == $yearValue ? 'selected' : '' }}>
                                            {{ $yearValue }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label>Base Salary *</label>
                            <input type="number" step="0.01" name="base_salary" class="form-control" value="{{ old('base_salary') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label>Overtime Hours</label>
                            <input type="number" name="overtime_hours" class="form-control" value="{{ old('overtime_hours', 0) }}">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Bonuses</label>
                                <input type="number" step="0.01" name="bonuses" class="form-control" value="{{ old('bonuses', 0) }}">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label>Allowances</label>
                                <input type="number" step="0.01" name="allowances" class="form-control" value="{{ old('allowances', 0) }}">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label>Deductions</label>
                            <input type="number" step="0.01" name="deductions" class="form-control" value="{{ old('deductions', 0) }}">
                        </div>
                        
                        <div class="mb-3">
                            <label>Status *</label>
                            <select name="status" class="form-control" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="generated" {{ old('status') == 'generated' ? 'selected' : '' }}>Generated</option>
                                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            </select>
                        </div>
                        
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Create Payroll</button>
                            <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Generate from Contract</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('payrolls.generate-from-contract') }}">
                        @csrf
                        <div class="mb-3">
                            <label>Employee</label>
                            <select name="employee_id" class="form-control" required>
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Month</label>
                            <select name="month" class="form-control" required>
                                @foreach($months as $key => $monthName)
                                    <option value="{{ $key }}">{{ $monthName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Year</label>
                            <select name="year" class="form-control" required>
                                @foreach($years as $yearValue)
                                    <option value="{{ $yearValue }}">{{ $yearValue }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info w-100">Generate from Contract</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection