@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Create New Contract</h1>
    
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
            <form method="POST" action="{{ route('contracts.store') }}" enctype="multipart/form-data">
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
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Contract Type *</label>
                        <select name="type" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="permanent" {{ old('type') == 'permanent' ? 'selected' : '' }}>Permanent</option>
                            <option value="fixed-term" {{ old('type') == 'fixed-term' ? 'selected' : '' }}>Fixed Term</option>
                            <option value="internship" {{ old('type') == 'internship' ? 'selected' : '' }}>Internship</option>
                            <option value="freelance" {{ old('type') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Position *</label>
                        <input type="text" name="position" class="form-control" value="{{ old('position') }}" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Base Salary *</label>
                        <input type="number" step="0.01" name="base_salary" class="form-control" value="{{ old('base_salary') }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Bonus</label>
                        <input type="number" step="0.01" name="bonus" class="form-control" value="{{ old('bonus', 0) }}">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Start Date *</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>End Date (for fixed-term)</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label>Contract Document (PDF/DOC)</label>
                    <input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx">
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Create Contract</button>
                    <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection