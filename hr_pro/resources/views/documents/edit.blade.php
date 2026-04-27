@extends('layouts.app')

@section('title', 'Edit Document')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Document</h3>
                    <a href="{{ route('documents.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('documents.update', $document) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Employee *</label>
                            <select class="form-control @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" required>
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id', $document->employee_id) == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->getFullName() }} ({{ $employee->email }})
                                </option>
                                @endforeach
                            </select>
                            @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Document Type *</label>
                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="cv" {{ old('type', $document->type) == 'cv' ? 'selected' : '' }}>CV / Resume</option>
                                <option value="contract" {{ old('type', $document->type) == 'contract' ? 'selected' : '' }}>Contract</option>
                                <option value="attestation" {{ old('type', $document->type) == 'attestation' ? 'selected' : '' }}>Attestation / Certificate</option>
                                <option value="other" {{ old('type', $document->type) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="document" class="form-label">Replace Document (Optional)</label>
                            <input type="file" class="form-control @error('document') is-invalid @enderror" 
                                   id="document" name="document" accept=".pdf,.doc,.docx,.jpg,.png">
                            <small class="text-muted">
                                Current file: {{ $document->file_name }} ({{ $document->getFileSizeFormatted() }})
                                <br>Leave empty to keep current file.
                            </small>
                            @error('document')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Document</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection