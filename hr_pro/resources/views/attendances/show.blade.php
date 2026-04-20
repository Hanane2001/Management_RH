@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Attendance Details</h1>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Attendance Information</h4>
                </div>
                <div class="card-body">
                    <p><strong>Employee:</strong> {{ $attendance->employee->first_name }} {{ $attendance->employee->last_name }}</p>
                    <p><strong>Date:</strong> {{ $attendance->date->format('d/m/Y') }}</p>
                    <p><strong>Check In:</strong> {{ $attendance->getCheckInFormatted() }}</p>
                    <p><strong>Check Out:</strong> {{ $attendance->getCheckOutFormatted() }}</p>
                    <p><strong>Hours Worked:</strong> {{ $attendance->hours_worked ?? '-' }}</p>
                    <p><strong>Status:</strong> {!! $attendance->getStatusBadge() !!}</p>
                    @if($attendance->isLate())
                        <p><strong>Note:</strong> <span class="text-warning">Late arrival</span></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Back</a>
        @can('update', $attendance)
            <a href="{{ route('attendances.edit', $attendance) }}" class="btn btn-warning">Edit</a>
        @endcan
        @can('delete', $attendance)
            <form action="{{ route('attendances.destroy', $attendance) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this attendance?')">Delete</button>
            </form>
        @endcan
    </div>
</div>
@endsection