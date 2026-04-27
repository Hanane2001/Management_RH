@extends('layouts.app')

@section('title', 'Edit Contract')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Contract</h3>
                    <a href="{{ route('contracts.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('contracts.update', $contract) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="employee_id" class="form-label">Employee *</label>
                                <select class="form-control @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" required>
                                    <option value="">Select Employee</option>
                                    @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ old('employee_id', $contract->employee_id) == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->getFullName() }} ({{ $employee->email }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="position" class="form-label">Position *</label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror" 
                                       id="position" name="position" value="{{ old('position', $contract->position) }}" required>
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Contract Type *</label>
                                <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="permanent" {{ old('type', $contract->type) == 'permanent' ? 'selected' : '' }}>Permanent</option>
                                    <option value="fixed-term" {{ old('type', $contract->type) == 'fixed-term' ? 'selected' : '' }}>Fixed Term</option>
                                    <option value="internship" {{ old('type', $contract->type) == 'internship' ? 'selected' : '' }}>Internship</option>
                                    <option value="freelance" {{ old('type', $contract->type) == 'freelance' ? 'selected' : '' }}>Freelance</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="base_salary" class="form-label">Base Salary (DH) *</label>
                                <input type="number" step="0.01" class="form-control @error('base_salary') is-invalid @enderror" 
                                       id="base_salary" name="base_salary" value="{{ old('base_salary', $contract->base_salary) }}" required>
                                @error('base_salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Start Date *</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" name="start_date" value="{{ old('start_date', $contract->start_date->format('Y-m-d')) }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">End Date (Leave empty for permanent)</label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                       id="end_date" name="end_date" value="{{ old('end_date', $contract->end_date ? $contract->end_date->format('Y-m-d') : '') }}">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="bonus" class="form-label">Bonus (DH)</label>
                                <input type="number" step="0.01" class="form-control @error('bonus') is-invalid @enderror" 
                                       id="bonus" name="bonus" value="{{ old('bonus', $contract->bonus) }}">
                                @error('bonus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="document" class="form-label">Contract Document (PDF)</label>
                                <input type="file" class="form-control @error('document') is-invalid @enderror" 
                                       id="document" name="document" accept=".pdf,.doc,.docx">
                                @if($contract->document_path)
                                    <small class="text-muted">Current file: <a href="{{ asset('storage/' . $contract->document_path) }}" target="_blank">View</a></small>
                                @endif
                                @error('document')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Contract</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection