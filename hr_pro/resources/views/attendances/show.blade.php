@extends('layouts.app')

@section('title', 'Attendance Details')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Attendance Details</h3>
                    <a href="{{ route('attendances.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Employee</th>
                            <td>{{ $attendance->employee->getFullName() }}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{ $attendance->date->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Check In Time</th>
                            <td>{{ $attendance->getCheckInFormatted() }}</td>
                        </tr>
                        <tr>
                            <th>Check Out Time</th>
                            <td>{{ $attendance->getCheckOutFormatted() }}</td>
                        </tr>
                        <tr>
                            <th>Hours Worked</th>
                            <td><strong>{{ $attendance->hours_worked ?? 0 }} hours</strong></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($attendance->status == 'present')
                                    <span class="badge bg-success">Present</span>
                                @elseif($attendance->status == 'absent')
                                    <span class="badge bg-danger">Absent</span>
                                @elseif($attendance->status == 'late')
                                    <span class="badge bg-warning">Late</span>
                                @else
                                    <span class="badge bg-info">Half Day</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Late Check In</th>
                            <td>{{ $attendance->isLate() ? 'Yes' : 'No' }}</td>
                        </tr>
                    </table>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        @can('update', $attendance)
                        <a href="{{ route('attendances.edit', $attendance) }}" class="btn btn-warning">Edit</a>
                        @endcan
                        @can('delete', $attendance)
                        <form method="POST" action="{{ route('attendances.destroy', $attendance) }}" class="d-inline" 
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection