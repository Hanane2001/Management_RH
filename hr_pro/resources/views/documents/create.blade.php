@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Upload Document</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label>Employee *</label>
                    <select name="employee_id" class="form-control" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->first_name }} {{ $employee->last_name }} ({{ $employee->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label>Document Type *</label>
                    <select name="type" class="form-control" required>
                        <option value="">Select Type</option>
                        <option value="cv" {{ old('type') == 'cv' ? 'selected' : '' }}>CV</option>
                        <option value="contract" {{ old('type') == 'contract' ? 'selected' : '' }}>Contract</option>
                        <option value="attestation" {{ old('type') == 'attestation' ? 'selected' : '' }}>Attestation</option>
                        <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label>Document File *</label>
                    <input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png" required>
                    <small class="text-muted">Allowed: PDF, DOC, DOCX, JPG, PNG (Max 5MB)</small>
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Upload Document</button>
                    <a href="{{ route('documents.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection