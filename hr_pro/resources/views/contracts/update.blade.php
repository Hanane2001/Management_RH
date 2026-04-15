@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Contract</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('contracts.update', $contract->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Employee:</label>
            <select name="employee_id" class="form-control" required>
                <option value="">Select Employee</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ $contract->employee_id == $employee->id ? 'selected' : '' }}>
                        {{ $employee->first_name }} {{ $employee->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Contract Type:</label>
            <select name="type" class="form-control" required>
                <option value="permanent" {{ $contract->type == 'permanent' ? 'selected' : '' }}>Permanent</option>
                <option value="fixed-term" {{ $contract->type == 'fixed-term' ? 'selected' : '' }}>Fixed Term</option>
                <option value="internship" {{ $contract->type == 'internship' ? 'selected' : '' }}>Internship</option>
                <option value="freelance" {{ $contract->type == 'freelance' ? 'selected' : '' }}>Freelance</option>
            </select>
        </div>

        <div class="form-group">
            <label>Base Salary:</label>
            <input type="number" step="0.01" name="base_salary" class="form-control" value="{{ $contract->base_salary }}" required>
        </div>

        <div class="form-group">
            <label>Bonus:</label>
            <input type="number" step="0.01" name="bonus" class="form-control" value="{{ $contract->bonus }}">
        </div>

        <div class="form-group">
            <label>Position:</label>
            <input type="text" name="position" class="form-control" value="{{ $contract->position }}" required>
        </div>

        <div class="form-group">
            <label>Start Date:</label>
            <input type="date" name="start_date" class="form-control" value="{{ $contract->start_date }}" required>
        </div>

        <div class="form-group">
            <label>End Date (Optional):</label>
            <input type="date" name="end_date" class="form-control" value="{{ $contract->end_date }}">
        </div>

        <div class="form-group">
            <label>Current Document:</label><br>
            @if($contract->document_path)
                <a href="{{ asset('storage/'.$contract->document_path) }}" target="_blank">View Current Document</a>
            @else
                <span>No document uploaded</span>
            @endif
        </div>

        <div class="form-group">
            <label>Upload New Document (Optional):</label>
            <input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx">
        </div>

        <button type="submit" class="btn btn-primary">Update Contract</button>
        <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection