@extends('layouts.app')

@section('title', 'Upload Document')

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
    
    .form-hint {
        display: block;
        font-family: 'Roboto', sans-serif;
        font-size: 0.7rem;
        color: #6B7280;
        margin-top: 5px;
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
    }
    
    .btn-submit:hover {
        background: #1E3A8A;
        transform: translateY(-1px);
    }
    
    .upload-area {
        border: 2px dashed #E5E7EB;
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .upload-area:hover {
        border-color: #1D4ED8;
        background: #F9FAFB;
    }
    
    .upload-area i {
        font-size: 2rem;
        color: #9CA3AF;
        margin-bottom: 10px;
    }
    
    .upload-area p {
        font-family: 'Roboto', sans-serif;
        color: #6B7280;
        font-size: 0.85rem;
    }
    
    @media (max-width: 768px) {
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
                <i class="fas fa-cloud-upload-alt"></i> Upload New Document
            </h3>
            <a href="{{ route('documents.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="form-body">
            <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
                @csrf
                
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
                    <label class="form-label">Document Type <span>*</span></label>
                    <select class="form-select @error('type') is-invalid @enderror" name="type" required>
                        <option value="">Select type...</option>
                        <option value="cv" {{ old('type') == 'cv' ? 'selected' : '' }}>📄 CV / Resume</option>
                        <option value="contract" {{ old('type') == 'contract' ? 'selected' : '' }}>📑 Contract</option>
                        <option value="attestation" {{ old('type') == 'attestation' ? 'selected' : '' }}>🎓 Attestation / Certificate</option>
                        <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>📁 Other</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Document File <span>*</span></label>
                    <div class="upload-area" onclick="document.getElementById('file-input').click()">
                        <i class="fas fa-file-upload"></i>
                        <p>Click to browse or drag and drop</p>
                        <p style="font-size: 0.7rem;">PDF, DOC, DOCX, JPG, PNG up to 10MB</p>
                    </div>
                    <input type="file" id="file-input" class="form-input @error('document') is-invalid @enderror" 
                           name="document" accept=".pdf,.doc,.docx,.jpg,.png" style="display: none;" required>
                    <span id="file-name" class="form-hint">No file selected</span>
                    @error('document')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-cloud-upload-alt"></i> Upload Document
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('file-input').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'No file selected';
        document.getElementById('file-name').textContent = fileName;
    });
</script>
@endsection