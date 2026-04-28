@extends('layouts.app')

@section('title', 'Edit Leave Balance')

@section('content')
<style>
    .form-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
        max-width: 600px;
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
    
    .form-input-disabled {
        background: #F9FAFB;
        color: #6B7280;
    }
    
    .invalid-feedback {
        color: #EF4444;
        font-family: 'Roboto', sans-serif;
        font-size: 0.75rem;
        margin-top: 5px;
    }
    
    .remaining-hint {
        margin-top: 8px;
        font-size: 0.75rem;
        font-family: 'Roboto', sans-serif;
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
        margin-top: 10px;
    }
    
    .btn-submit:hover {
        background: #1E3A8A;
        transform: translateY(-1px);
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
    }
</style>

<div class="container-fluid">
    <div class="form-card">
        <div class="form-header">
            <h3>
                <i class="fas fa-edit"></i> Edit Leave Balance
            </h3>
            <a href="{{ route('leave-balances.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="form-body">
            <form method="POST" action="{{ route('leave-balances.update', $leaveBalance) }}">
                @csrf
                @method('PUT')
                
                <div class="form-grid">
                    <div class="form-group-full">
                        <label class="form-label">Employee <span>*</span></label>
                        <select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id" required>
                            <option value="">Select employee...</option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id', $leaveBalance->employee_id) == $employee->id ? 'selected' : '' }}>
                                {{ $employee->getFullName() }} ({{ $employee->email }})
                            </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Year <span>*</span></label>
                        <input type="number" class="form-input @error('year') is-invalid @enderror" 
                               name="year" value="{{ old('year', $leaveBalance->year) }}" required min="2000" max="2030">
                        @error('year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Total Days <span>*</span></label>
                        <input type="number" class="form-input @error('total_days') is-invalid @enderror" 
                               name="total_days" value="{{ old('total_days', $leaveBalance->total_days) }}" required min="1" max="365" id="total_days">
                        @error('total_days')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Used Days <span>*</span></label>
                        <input type="number" class="form-input @error('used_days') is-invalid @enderror" 
                               name="used_days" value="{{ old('used_days', $leaveBalance->used_days) }}" required min="0" id="used_days">
                        @error('used_days')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Remaining Days</label>
                        <input type="text" class="form-input form-input-disabled" id="remaining_display" readonly disabled>
                        <div class="remaining-hint" id="remaining_hint"></div>
                    </div>
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Update Leave Balance
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function calculateRemaining() {
        let total = parseInt(document.getElementById('total_days').value) || 0;
        let used = parseInt(document.getElementById('used_days').value) || 0;
        let remaining = total - used;
        
        const displayField = document.getElementById('remaining_display');
        const hintField = document.getElementById('remaining_hint');
        
        displayField.value = remaining + ' days';
        
        if (remaining < 0) {
            displayField.style.color = '#EF4444';
            hintField.innerHTML = '<span style="color: #EF4444;">⚠️ Used days cannot exceed total days</span>';
        } else if (remaining < 5) {
            displayField.style.color = '#F59E0B';
            hintField.innerHTML = '<span style="color: #F59E0B;">⚠️ Low balance - less than 5 days remaining</span>';
        } else {
            displayField.style.color = '#6B7280';
            hintField.innerHTML = '';
        }
    }
    
    document.getElementById('total_days').addEventListener('input', calculateRemaining);
    document.getElementById('used_days').addEventListener('input', calculateRemaining);
    calculateRemaining();
</script>
@endsection