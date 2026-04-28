@extends('layouts.app')

@section('title', 'Request Leave')

@section('content')
<style>
    .form-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
        max-width: 700px;
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
    
    .alert-info {
        background: #EFF6FF;
        border: 1px solid #BFDBFE;
        color: #1E40AF;
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .alert-info i {
        font-size: 1.2rem;
    }
    
    .alert-info strong {
        font-weight: 600;
    }
    
    .form-body {
        padding: 24px;
    }
    
    .form-group {
        margin-bottom: 20px;
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
    
    .form-input, .form-select, .form-textarea {
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
    
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color: #1D4ED8;
        box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1);
    }
    
    .form-input.is-invalid, .form-select.is-invalid, .form-textarea.is-invalid {
        border-color: #EF4444;
    }
    
    .invalid-feedback {
        color: #EF4444;
        font-family: 'Roboto', sans-serif;
        font-size: 0.75rem;
        margin-top: 5px;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
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
    
    .duration-preview {
        background: #F3F4F6;
        padding: 10px 15px;
        border-radius: 10px;
        margin-top: 10px;
        font-size: 0.85rem;
        color: #374151;
        display: none;
    }
    
    .duration-preview.show {
        display: block;
    }
    
    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
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
                <i class="fas fa-calendar-plus"></i> Request Leave
            </h3>
            <a href="{{ route('leaves.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="form-body">
            <div class="alert-info">
                <i class="fas fa-info-circle"></i>
                <div>
                    <strong>Your Leave Balance:</strong> {{ $balance->remaining_days }} days remaining
                </div>
            </div>
            
            <form method="POST" action="{{ route('leaves.store') }}" id="leaveForm">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Leave Type <span>*</span></label>
                    <select class="form-select @error('type') is-invalid @enderror" name="type" id="type" required>
                        <option value="">Select leave type...</option>
                        <option value="paid" {{ old('type') == 'paid' ? 'selected' : '' }}>Paid Leave (Annual)</option>
                        <option value="sick" {{ old('type') == 'sick' ? 'selected' : '' }}>Sick Leave</option>
                        <option value="unpaid" {{ old('type') == 'unpaid' ? 'selected' : '' }}>Unpaid Leave</option>
                        <option value="exceptional" {{ old('type') == 'exceptional' ? 'selected' : '' }}>Exceptional Leave</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Start Date <span>*</span></label>
                        <input type="date" class="form-input @error('start_date') is-invalid @enderror" 
                               name="start_date" id="start_date" value="{{ old('start_date') }}" required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">End Date <span>*</span></label>
                        <input type="date" class="form-input @error('end_date') is-invalid @enderror" 
                               name="end_date" id="end_date" value="{{ old('end_date') }}" required>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div id="durationPreview" class="duration-preview"></div>
                
                <div class="form-group">
                    <label class="form-label">Reason</label>
                    <textarea class="form-textarea @error('reason') is-invalid @enderror" 
                              name="reason" rows="4" placeholder="Please provide a reason for your leave request...">{{ old('reason') }}</textarea>
                    @error('reason')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Submit Request
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function calculateDuration() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        const preview = document.getElementById('durationPreview');
        
        if (startDate && endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);
            
            if (start <= end) {
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                preview.innerHTML = `<i class="fas fa-calculator"></i> Duration: ${diffDays} day(s)`;
                preview.classList.add('show');
            } else {
                preview.innerHTML = '<i class="fas fa-exclamation-triangle" style="color: #EF4444;"></i> End date must be after start date';
                preview.classList.add('show');
            }
        } else {
            preview.classList.remove('show');
        }
    }
    
    document.getElementById('start_date').addEventListener('change', calculateDuration);
    document.getElementById('end_date').addEventListener('change', calculateDuration);
</script>
@endpush
@endsection