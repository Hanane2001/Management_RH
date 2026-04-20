@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Document</h1>
    
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
            <form method="POST" action="{{ route('documents.update', $document) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label>Employee</label>
                    <select name="employee_id" class="form-control" required>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id', $document->employee_id) == $employee->id ? 'selected' : '' }}>
                                {{ $employee->first_name }} {{ $employee->last_name }} ({{ $employee->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label>Document Type</label>
                    <select name="type" class="form-control" required>
                        <option value="cv" {{ old('type', $document->type) == 'cv' ? 'selected' : '' }}>CV</option>
                        <option value="contract" {{ old('type', $document->type) == 'contract' ? 'selected' : '' }}>Contract</option>
                        <option value="attestation" {{ old('type', $document->type) == 'attestation' ? 'selected' : '' }}>Attestation</option>
                        <option value="other" {{ old('type', $document->type) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label>Current File</label><br>
                    <strong>{{ $document->getIcon() }} {{ $document->file_name }}</strong>
                    ({{ $document->getFileSizeFormatted() }})
                </div>
                
                <div class="mb-3">
                    <label>Replace with New File (Optional)</label>
                    <input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
                    <small class="text-muted">Leave empty to keep current file</small>
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Update Document</button>
                    <a href="{{ route('documents.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection