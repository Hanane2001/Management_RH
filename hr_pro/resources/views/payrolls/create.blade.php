@extends('layouts.app')

@section('title', 'Add Payroll')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Payroll Record</h3>
                    <a href="{{ route('payrolls.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('payrolls.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="employee_id" class="form-label">Employee *</label>
                                <select class="form-control @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" required>
                                    <option value="">Select Employee</option>
                                    @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->getFullName() }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="generated" {{ old('status') == 'generated' ? 'selected' : '' }}>Generated</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="month" class="form-label">Month *</label>
                                <select class="form-control @error('month') is-invalid @enderror" id="month" name="month" required>
                                    @foreach($months as $key => $monthName)
                                    <option value="{{ $key }}" {{ old('month') == $key ? 'selected' : '' }}>
                                        {{ $monthName }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('month')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="year" class="form-label">Year *</label>
                                <select class="form-control @error('year') is-invalid @enderror" id="year" name="year" required>
                                    @foreach($years as $yearOption)
                                    <option value="{{ $yearOption }}" {{ old('year') == $yearOption ? 'selected' : '' }}>
                                        {{ $yearOption }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="base_salary" class="form-label">Base Salary (DH) *</label>
                                <input type="number" step="0.01" class="form-control @error('base_salary') is-invalid @enderror" 
                                       id="base_salary" name="base_salary" value="{{ old('base_salary') }}" required>
                                @error('base_salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="overtime_hours" class="form-label">Overtime Hours</label>
                                <input type="number" step="0.5" class="form-control @error('overtime_hours') is-invalid @enderror" 
                                       id="overtime_hours" name="overtime_hours" value="{{ old('overtime_hours', 0) }}">
                                @error('overtime_hours')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="bonuses" class="form-label">Bonuses (DH)</label>
                                <input type="number" step="0.01" class="form-control @error('bonuses') is-invalid @enderror" 
                                       id="bonuses" name="bonuses" value="{{ old('bonuses', 0) }}">
                                @error('bonuses')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="allowances" class="form-label">Allowances (DH)</label>
                                <input type="number" step="0.01" class="form-control @error('allowances') is-invalid @enderror" 
                                       id="allowances" name="allowances" value="{{ old('allowances', 0) }}">
                                @error('allowances')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="deductions" class="form-label">Deductions (DH)</label>
                                <input type="number" step="0.01" class="form-control @error('deductions') is-invalid @enderror" 
                                       id="deductions" name="deductions" value="{{ old('deductions', 0) }}">
                                @error('deductions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Net Pay</label>
                            <input type="text" class="form-control" id="net_pay_display" readonly disabled>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Create Payroll</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function calculateNetPay() {
        let baseSalary = parseFloat(document.getElementById('base_salary').value) || 0;
        let bonuses = parseFloat(document.getElementById('bonuses').value) || 0;
        let allowances = parseFloat(document.getElementById('allowances').value) || 0;
        let deductions = parseFloat(document.getElementById('deductions').value) || 0;
        let overtimeHours = parseFloat(document.getElementById('overtime_hours').value) || 0;
        
        let total = baseSalary + bonuses + allowances;
        
        if (overtimeHours > 0) {
            let dailyRate = baseSalary / 22;
            let hourlyRate = dailyRate / 8;
            total += overtimeHours * hourlyRate * 1.5;
        }
        
        let netPay = total - deductions;
        document.getElementById('net_pay_display').value = netPay.toFixed(2) + ' DH';
    }
    
    document.getElementById('base_salary').addEventListener('input', calculateNetPay);
    document.getElementById('bonuses').addEventListener('input', calculateNetPay);
    document.getElementById('allowances').addEventListener('input', calculateNetPay);
    document.getElementById('deductions').addEventListener('input', calculateNetPay);
    document.getElementById('overtime_hours').addEventListener('input', calculateNetPay);
    calculateNetPay();
</script>
@endpush
@endsection