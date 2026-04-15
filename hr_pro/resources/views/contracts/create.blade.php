@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Contract</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('contracts.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Employee</label>
            <select name="employee_id" class="form-control" required>
                <option value="">Select Employee</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">
                        {{ $employee->first_name }} {{ $employee->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Contract Type</label>
            <select name="type" class="form-control" required>
                <option value="permanent">Permanent</option>
                <option value="fixed-term">Fixed Term</option>
                <option value="internship">Internship</option>
                <option value="freelance">Freelance</option>
            </select>
        </div>

        <div class="form-group">
            <label>Base Salary</label>
            <input type="number" step="0.01" name="base_salary" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Bonus</label>
            <input type="number" step="0.01" name="bonus" class="form-control" value="0">
        </div>

        <div class="form-group">
            <label>Position</label>
            <input type="text" name="position" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label>End Date (Optional)</label>
            <input type="date" name="end_date" class="form-control">
        </div>

        <div class="form-group">
            <label>Document (PDF)</label>
            <input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx">
        </div>

        <button type="submit" class="btn btn-primary">Save Contract</button>
        <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection