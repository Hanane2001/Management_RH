@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Add Attendance</h1>
    
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
            <form method="POST" action="{{ route('attendances.store') }}">
                @csrf
                
                <div class="mb-3">
                    <label>Employee *</label>
                    <select name="employee_id" class="form-control" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->first_name }} {{ $employee->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label>Date *</label>
                    <input type="date" name="date" class="form-control" value="{{ old('date', $today) }}" required>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Check In</label>
                        <input type="time" name="check_in" class="form-control" value="{{ old('check_in') }}">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Check Out</label>
                        <input type="time" name="check_out" class="form-control" value="{{ old('check_out') }}">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label>Status *</label>
                    <select name="status" class="form-control" required>
                        <option value="present" {{ old('status') == 'present' ? 'selected' : '' }}>Present</option>
                        <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                        <option value="late" {{ old('status') == 'late' ? 'selected' : '' }}>Late</option>
                        <option value="half-day" {{ old('status') == 'half-day' ? 'selected' : '' }}>Half Day</option>
                    </select>
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Save Attendance</button>
                    <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection