@extends('layouts.app')

@section('title', 'Edit Attendance')

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
        background: #10B981;
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
        background: #059669;
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
                <i class="fas fa-edit"></i> Edit Attendance Record
            </h3>
            <a href="{{ route('attendances.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="form-body">
            <form method="POST" action="{{ route('attendances.update', $attendance) }}">
                @csrf
                @method('PUT')
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Employee <span>*</span></label>
                        <select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id" required>
                            <option value="">Select Employee...</option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id', $attendance->employee_id) == $employee->id ? 'selected' : '' }}>
                                {{ $employee->getFullName() }}
                            </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Date <span>*</span></label>
                        <input type="date" class="form-input @error('date') is-invalid @enderror" 
                               name="date" value="{{ old('date', $attendance->date->format('Y-m-d')) }}" required>
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Check In Time</label>
                        <input type="time" class="form-input @error('check_in') is-invalid @enderror" 
                               name="check_in" value="{{ old('check_in', $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '') }}">
                        @error('check_in')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Check Out Time</label>
                        <input type="time" class="form-input @error('check_out') is-invalid @enderror" 
                               name="check_out" value="{{ old('check_out', $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '') }}">
                        @error('check_out')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group-full">
                        <label class="form-label">Status <span>*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                            <option value="">Select status...</option>
                            <option value="present" {{ old('status', $attendance->status) == 'present' ? 'selected' : '' }}>Present</option>
                            <option value="absent" {{ old('status', $attendance->status) == 'absent' ? 'selected' : '' }}>Absent</option>
                            <option value="late" {{ old('status', $attendance->status) == 'late' ? 'selected' : '' }}>Late</option>
                            <option value="half-day" {{ old('status', $attendance->status) == 'half-day' ? 'selected' : '' }}>Half Day</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Update Attendance
                </button>
            </form>
        </div>
    </div>
</div>
@endsection