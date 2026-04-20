@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Attendance</h1>
    
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
            <form method="POST" action="{{ route('attendances.update', $attendance) }}">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label>Employee *</label>
                    <select name="employee_id" class="form-control" required>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id', $attendance->employee_id) == $employee->id ? 'selected' : '' }}>
                                {{ $employee->first_name }} {{ $employee->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label>Date *</label>
                    <input type="date" name="date" class="form-control" value="{{ old('date', $attendance->date->format('Y-m-d')) }}" required>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Check In</label>
                        <input type="time" name="check_in" class="form-control" value="{{ old('check_in', $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '') }}">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Check Out</label>
                        <input type="time" name="check_out" class="form-control" value="{{ old('check_out', $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '') }}">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label>Status *</label>
                    <select name="status" class="form-control" required>
                        <option value="present" {{ old('status', $attendance->status) == 'present' ? 'selected' : '' }}>Present</option>
                        <option value="absent" {{ old('status', $attendance->status) == 'absent' ? 'selected' : '' }}>Absent</option>
                        <option value="late" {{ old('status', $attendance->status) == 'late' ? 'selected' : '' }}>Late</option>
                        <option value="half-day" {{ old('status', $attendance->status) == 'half-day' ? 'selected' : '' }}>Half Day</option>
                    </select>
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Update Attendance</button>
                    <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection