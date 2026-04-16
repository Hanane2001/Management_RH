@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Contract</h1>
    
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
            <form method="POST" action="{{ route('contracts.update', $contract->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label>Employee *</label>
                    <select name="employee_id" class="form-control" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id', $contract->employee_id) == $employee->id ? 'selected' : '' }}>
                                {{ $employee->first_name }} {{ $employee->last_name }} ({{ $employee->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Contract Type *</label>
                        <select name="type" class="form-control" required>
                            <option value="permanent" {{ old('type', $contract->type) == 'permanent' ? 'selected' : '' }}>Permanent</option>
                            <option value="fixed-term" {{ old('type', $contract->type) == 'fixed-term' ? 'selected' : '' }}>Fixed Term</option>
                            <option value="internship" {{ old('type', $contract->type) == 'internship' ? 'selected' : '' }}>Internship</option>
                            <option value="freelance" {{ old('type', $contract->type) == 'freelance' ? 'selected' : '' }}>Freelance</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Position *</label>
                        <input type="text" name="position" class="form-control" value="{{ old('position', $contract->position) }}" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Base Salary *</label>
                        <input type="number" step="0.01" name="base_salary" class="form-control" value="{{ old('base_salary', $contract->base_salary) }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Bonus</label>
                        <input type="number" step="0.01" name="bonus" class="form-control" value="{{ old('bonus', $contract->bonus) }}">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Start Date *</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $contract->start_date->format('Y-m-d')) }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $contract->end_date ? $contract->end_date->format('Y-m-d') : '') }}">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label>Current Document</label><br>
                    @if($contract->document_path)
                        <a href="{{ asset('storage/'.$contract->document_path) }}" target="_blank" class="btn btn-sm btn-info">View Current Document</a>
                    @else
                        <span class="text-muted">No document uploaded</span>
                    @endif
                </div>
                
                <div class="mb-3">
                    <label>Upload New Document (Optional)</label>
                    <input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx">
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Update Contract</button>
                    <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection