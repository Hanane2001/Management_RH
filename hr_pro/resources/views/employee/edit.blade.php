@extends('layouts.app')

@section('title', 'Edit Employee')

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
    
    .btn-secondary {
        background: #F3F4F6;
        color: #374151;
        padding: 12px 24px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        margin-left: 10px;
    }
    
    .btn-secondary:hover {
        background: #E5E7EB;
    }
    
    .button-group {
        display: flex;
        gap: 10px;
        margin-top: 24px;
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
        
        .button-group {
            flex-direction: column;
        }
    }
</style>

<div class="container-fluid">
    <div class="form-card">
        <div class="form-header">
            <h3>
                <i class="fas fa-user-edit"></i> Edit Employee: {{ $employee->getFullName() }}
            </h3>
            <a href="{{ route('employees.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="form-body">
            <form method="POST" action="{{ route('employees.update', $employee) }}">
                @csrf
                @method('PUT')
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">First Name <span>*</span></label>
                        <input type="text" class="form-input" name="first_name" value="{{ old('first_name', $employee->first_name) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Last Name <span>*</span></label>
                        <input type="text" class="form-input" name="last_name" value="{{ old('last_name', $employee->last_name) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Email <span>*</span></label>
                        <input type="email" class="form-input" name="email" value="{{ old('email', $employee->email) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-input" name="phone" value="{{ old('phone', $employee->phone) }}">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Department</label>
                        <select class="form-select" name="department_id">
                            <option value="">Select department...</option>
                            @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Birth Date</label>
                        <input type="date" class="form-input" name="birth_date" value="{{ old('birth_date', $employee->birth_date) }}">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">ID Number</label>
                        <input type="text" class="form-input" name="id_number" value="{{ old('id_number', $employee->id_number) }}">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Social Security Number</label>
                        <input type="text" class="form-input" name="social_security_number" value="{{ old('social_security_number', $employee->social_security_number) }}">
                    </div>
                    
                    <div class="form-group-full">
                        <label class="form-label">Address</label>
                        <textarea class="form-textarea" name="address" rows="2">{{ old('address', $employee->address) }}</textarea>
                    </div>
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn-submit" style="margin: 0;">
                        <i class="fas fa-save"></i> Update Employee
                    </button>
                    <a href="{{ route('employees.index') }}" class="btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection