@extends('layouts.app')

@section('title', 'Edit Payroll')

@section('content')
<style>
    .form-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
        max-width: 900px;
        margin: 0 auto;
    }
    
    .form-header {
        padding: 20px 24px;
        border-bottom: 1px solid #E5E7EB;
        background: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .form-header h3 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 1.25rem;
        color: #1F2937;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .form-header h3 i {
        color: #1D4ED8;
    }
    
    .btn-back {
        background: #F3F4F6;
        color: #374151;
        padding: 8px 16px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-back:hover {
        background: #E5E7EB;
        color: #1F2937;
    }
    
    .form-body {
        padding: 24px;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    
    .form-group {
        margin-bottom: 0;
    }
    
    .form-group-full {
        grid-column: span 2;
    }
    
    .form-label {
        display: block;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 6px;
    }
    
    .form-label span {
        color: #EF4444;
    }
    
    .form-label small {
        font-weight: normal;
        color: #6B7280;
        font-size: 0.7rem;
    }
    
    .form-input, .form-select {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        font-family: 'Roboto', sans-serif;
        font-size: 0.9rem;
        transition: all 0.2s;
        outline: none;
        background: white;
    }
    
    .form-input:focus, .form-select:focus {
        border-color: #1D4ED8;
        box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1);
    }
    
    .form-input.is-invalid, .form-select.is-invalid {
        border-color: #EF4444;
    }
    
    .invalid-feedback {
        color: #EF4444;
        font-family: 'Roboto', sans-serif;
        font-size: 0.75rem;
        margin-top: 5px;
    }
    
    .readonly-field {
        background: #F9FAFB;
        color: #6B7280;
        cursor: not-allowed;
    }
    
    .net-pay-container {
        background: #F0FDF4;
        border-radius: 12px;
        padding: 16px 20px;
        margin-top: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .net-pay-label {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        color: #065F46;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .net-pay-label i {
        font-size: 1.1rem;
    }
    
    .net-pay-value {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 1.3rem;
        color: #10B981;
    }
    
    .help-text {
        font-size: 0.7rem;
        color: #9CA3AF;
        margin-top: 4px;
    }
    
    .btn-submit {
        background: #1D4ED8;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 24px;
    }
    
    .btn-submit:hover {
        background: #1E3A8A;
        transform: translateY(-1px);
    }
    
    .info-badge {
        background: #EFF6FF;
        color: #1D4ED8;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
        display: inline-block;
        margin-left: 8px;
    }
    
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        
        .form-group-full {
            grid-column: span 1;
        }
        
        .form-header {
            padding: 16px 20px;
        }
        
        .form-body {
            padding: 20px;
        }
        
        .net-pay-container {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="container-fluid">
    <div class="form-card">
        <div class="form-header">
            <h3>
                <i class="fas fa-edit"></i> Edit Payroll - {{ $payroll->getMonthName() }} {{ $payroll->year }}
            </h3>
            <a href="{{ route('payrolls.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        
        <div class="form-body">
            <form method="POST" action="{{ route('payrolls.update', $payroll) }}">
                @csrf
                @method('PUT')
                
                <div class="form-grid">
                    <!-- Employee -->
                    <div class="form-group">
                        <label class="form-label">Employee <span>*</span></label>
                        <select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id" required>
                            <option value="">Select employee...</option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id', $payroll->employee_id) == $employee->id ? 'selected' : '' }}>
                                {{ $employee->getFullName() }}
                            </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Status -->
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status">
                            <option value="draft" {{ old('status', $payroll->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="generated" {{ old('status', $payroll->status) == 'generated' ? 'selected' : '' }}>Generated</option>
                            @if($payroll->status == 'approved')
                            <option value="approved" selected>Approved</option>
                            @endif
                            @if($payroll->status == 'paid')
                            <option value="paid" selected>Paid</option>
                            @endif
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Month <span>*</span></label>
                        <select class="form-select @error('month') is-invalid @enderror" name="month" required>
                            @foreach($months as $key => $monthName)
                            <option value="{{ $key }}" {{ old('month', $payroll->month) == $key ? 'selected' : '' }}>
                                {{ $monthName }}
                            </option>
                            @endforeach
                        </select>
                        @error('month')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Year <span>*</span></label>
                        <select class="form-select @error('year') is-invalid @enderror" name="year" required>
                            @foreach($years as $yearOption)
                            <option value="{{ $yearOption }}" {{ old('year', $payroll->year) == $yearOption ? 'selected' : '' }}>
                                {{ $yearOption }}
                            </option>
                            @endforeach
                        </select>
                        @error('year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Base Salary <span>*</span> <small>(DH)</small></label>
                        <input type="number" step="0.01" class="form-input @error('base_salary') is-invalid @enderror" 
                               id="base_salary" name="base_salary" value="{{ old('base_salary', $payroll->base_salary) }}" 
                               placeholder="0.00" required>
                        @error('base_salary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Overtime Hours <small>(hours)</small></label>
                        <input type="number" step="0.5" class="form-input @error('overtime_hours') is-invalid @enderror" 
                               id="overtime_hours" name="overtime_hours" value="{{ old('overtime_hours', $payroll->overtime_hours) }}" 
                               placeholder="0">
                        <div class="help-text">Paid at 1.5x the hourly rate</div>
                        @error('overtime_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Bonuses <small>(DH)</small></label>
                        <input type="number" step="0.01" class="form-input @error('bonuses') is-invalid @enderror" 
                               id="bonuses" name="bonuses" value="{{ old('bonuses', $payroll->bonuses) }}" 
                               placeholder="0.00">
                        @error('bonuses')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Allowances <small>(DH)</small></label>
                        <input type="number" step="0.01" class="form-input @error('allowances') is-invalid @enderror" 
                               id="allowances" name="allowances" value="{{ old('allowances', $payroll->allowances) }}" 
                               placeholder="0.00">
                        @error('allowances')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Deductions <small>(DH)</small></label>
                        <input type="number" step="0.01" class="form-input @error('deductions') is-invalid @enderror" 
                               id="deductions" name="deductions" value="{{ old('deductions', $payroll->deductions) }}" 
                               placeholder="0.00">
                        @error('deductions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="net-pay-container">
                    <div class="net-pay-label">
                        <i class="fas fa-calculator"></i>
                        Net Pay
                    </div>
                    <div class="net-pay-value" id="net_pay_display">0.00 DH</div>
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Update Payroll
                </button>
            </form>
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
        
        if (overtimeHours > 0 && baseSalary > 0) {
            let dailyRate = baseSalary / 22;
            let hourlyRate = dailyRate / 8;
            let overtimePay = overtimeHours * hourlyRate * 1.5;
            total += overtimePay;
        }
        
        let netPay = total - deductions;
        document.getElementById('net_pay_display').innerText = netPay.toFixed(2) + ' DH';
    }
    const baseSalaryInput = document.getElementById('base_salary');
    const bonusesInput = document.getElementById('bonuses');
    const allowancesInput = document.getElementById('allowances');
    const deductionsInput = document.getElementById('deductions');
    const overtimeInput = document.getElementById('overtime_hours');
    
    if (baseSalaryInput) baseSalaryInput.addEventListener('input', calculateNetPay);
    if (bonusesInput) bonusesInput.addEventListener('input', calculateNetPay);
    if (allowancesInput) allowancesInput.addEventListener('input', calculateNetPay);
    if (deductionsInput) deductionsInput.addEventListener('input', calculateNetPay);
    if (overtimeInput) overtimeInput.addEventListener('input', calculateNetPay);
    calculateNetPay();
</script>
@endpush
@endsection