@extends('layouts.app')

@section('title', 'New Evaluation')

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
    
    .form-textarea {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        font-family: 'Roboto', sans-serif;
        font-size: 0.9rem;
        transition: all 0.2s;
        outline: none;
        resize: vertical;
    }
    
    .form-textarea:focus {
        border-color: #1D4ED8;
        box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1);
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
    
    .info-box {
        background: #EFF6FF;
        border: 1px solid #DBEAFE;
        border-radius: 12px;
        padding: 16px;
        margin-top: 20px;
    }
    
    .info-box h6 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        color: #1D4ED8;
        margin-bottom: 10px;
    }
    
    .info-box ul {
        margin: 0;
        padding-left: 20px;
    }
    
    .info-box li {
        font-family: 'Roboto', sans-serif;
        font-size: 0.8rem;
        color: #374151;
        margin-bottom: 5px;
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
                <i class="fas fa-star"></i> Create Performance Evaluation
            </h3>
            <a href="{{ route('evaluations.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="form-body">
            <form method="POST" action="{{ route('evaluations.store') }}">
                @csrf
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Employee <span>*</span></label>
                        <select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id" required>
                            <option value="">Select employee...</option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->getFullName() }} ({{ $employee->department->name ?? 'No Department' }})
                            </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Evaluation Date <span>*</span></label>
                        <input type="date" class="form-input @error('evaluation_date') is-invalid @enderror" 
                               name="evaluation_date" value="{{ old('evaluation_date', date('Y-m-d')) }}" required>
                        @error('evaluation_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group-full">
                        <label class="form-label">Evaluation Period <span>*</span></label>
                        <input type="text" class="form-input @error('period') is-invalid @enderror" 
                               name="period" value="{{ old('period') }}" required placeholder="e.g., Q1 2024, Annual 2024">
                        @error('period')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group-full">
                        <label class="form-label">Overall Score (%) <span>*</span></label>
                        <input type="number" step="1" min="0" max="100" class="form-input @error('overall_score') is-invalid @enderror" 
                               name="overall_score" value="{{ old('overall_score') }}" required>
                        @error('overall_score')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group-full">
                        <label class="form-label">Comments</label>
                        <textarea class="form-textarea @error('comments') is-invalid @enderror" 
                                  name="comments" rows="4" placeholder="Provide detailed feedback about employee performance...">{{ old('comments') }}</textarea>
                        @error('comments')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="info-box">
                    <h6><i class="fas fa-chart-line"></i> Evaluation Criteria</h6>
                    <ul>
                        <li><strong>90-100%</strong> - Excellent: Outstanding performance</li>
                        <li><strong>75-89%</strong> - Very Good: Exceeds expectations</li>
                        <li><strong>60-74%</strong> - Satisfactory: Meets expectations</li>
                        <li><strong>50-59%</strong> - Sufficient: Below expectations</li>
                        <li><strong>&lt;50%</strong> - Insufficient: Needs improvement</li>
                    </ul>
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Create Evaluation
                </button>
            </form>
        </div>
    </div>
</div>
@endsection