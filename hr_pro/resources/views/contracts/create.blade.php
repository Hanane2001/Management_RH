@extends('layouts.app')

@section('title', 'Add Contract')

@section('content')
<style>
    .form-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
        max-width: 800px;
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
                <i class="fas fa-plus-circle"></i> Add New Contract
            </h3>
            <a href="{{ route('contracts.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="form-body">
            <form method="POST" action="{{ route('contracts.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Employee <span>*</span></label>
                        <select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id" required>
                            <option value="">Select employee...</option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->getFullName() }} ({{ $employee->email }})
                            </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Position <span>*</span></label>
                        <input type="text" class="form-input @error('position') is-invalid @enderror" 
                               name="position" value="{{ old('position') }}" placeholder="e.g., Senior Developer" required>
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Contract Type <span>*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror" name="type" required>
                            <option value="">Select type...</option>
                            <option value="permanent" {{ old('type') == 'permanent' ? 'selected' : '' }}>Permanent</option>
                            <option value="fixed-term" {{ old('type') == 'fixed-term' ? 'selected' : '' }}>Fixed Term</option>
                            <option value="internship" {{ old('type') == 'internship' ? 'selected' : '' }}>Internship</option>
                            <option value="freelance" {{ old('type') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Base Salary <span>*</span> <small>(DH)</small></label>
                        <input type="number" step="0.01" class="form-input @error('base_salary') is-invalid @enderror" 
                               name="base_salary" value="{{ old('base_salary') }}" placeholder="0.00" required>
                        @error('base_salary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Start Date <span>*</span></label>
                        <input type="date" class="form-input @error('start_date') is-invalid @enderror" 
                               name="start_date" value="{{ old('start_date') }}" required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">End Date <small>(leave empty for permanent)</small></label>
                        <input type="date" class="form-input @error('end_date') is-invalid @enderror" 
                               name="end_date" value="{{ old('end_date') }}">
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Bonus <small>(DH)</small></label>
                        <input type="number" step="0.01" class="form-input @error('bonus') is-invalid @enderror" 
                               name="bonus" value="{{ old('bonus', 0) }}" placeholder="0.00">
                        @error('bonus')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Contract Document <small>(PDF, DOC)</small></label>
                        <input type="file" class="form-input @error('document') is-invalid @enderror" 
                               name="document" accept=".pdf,.doc,.docx">
                        @error('document')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Create Contract
                </button>
            </form>
        </div>
    </div>
</div>
@endsection