@extends('layouts.app')

@section('title', 'New Evaluation')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Performance Evaluation</h3>
                    <a href="{{ route('evaluations.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('evaluations.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="employee_id" class="form-label">Employee *</label>
                                <select class="form-control @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" required>
                                    <option value="">Select Employee</option>
                                    @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->getFullName() }} ({{ $employee->department->name ?? 'N/A' }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="evaluation_date" class="form-label">Evaluation Date *</label>
                                <input type="date" class="form-control @error('evaluation_date') is-invalid @enderror" 
                                       id="evaluation_date" name="evaluation_date" value="{{ old('evaluation_date', date('Y-m-d')) }}" required>
                                @error('evaluation_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="period" class="form-label">Evaluation Period *</label>
                            <input type="text" class="form-control @error('period') is-invalid @enderror" 
                                   id="period" name="period" value="{{ old('period') }}" required 
                                   placeholder="e.g., Q1 2024, Annual 2024">
                            @error('period')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="overall_score" class="form-label">Overall Score (%) *</label>
                            <input type="number" step="1" min="0" max="100" class="form-control @error('overall_score') is-invalid @enderror" 
                                   id="overall_score" name="overall_score" value="{{ old('overall_score') }}" required>
                            @error('overall_score')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="comments" class="form-label">Comments</label>
                            <textarea class="form-control @error('comments') is-invalid @enderror" 
                                      id="comments" name="comments" rows="5" placeholder="Provide detailed feedback...">{{ old('comments') }}</textarea>
                            @error('comments')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="alert alert-info">
                            <h6>Evaluation Criteria:</h6>
                            <ul>
                                <li><strong>90-100%:</strong> Excellent</li>
                                <li><strong>75-89%:</strong> Very Good</li>
                                <li><strong>60-74%:</strong> Satisfactory</li>
                                <li><strong>50-59%:</strong> Sufficient</li>
                                <li><strong>&lt;50%:</strong> Insufficient</li>
                            </ul>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Create Evaluation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection