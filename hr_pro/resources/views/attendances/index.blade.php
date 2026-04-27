@extends('layouts.app')

@section('title', 'Attendance')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Attendance Records</h3>
                    <div class="float-end">
                        <form method="GET" action="{{ route('attendances.index') }}" class="d-inline">
                            <div class="input-group">
                                <input type="date" name="date" value="{{ $date }}" class="form-control" style="width: auto;">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </form>
                        @can('create', App\Models\Attendance::class)
                        <a href="{{ route('attendances.create') }}" class="btn btn-primary ms-2">
                            <i class="fas fa-plus"></i> Add Attendance
                        </a>
                        @endcan
                        <a href="{{ route('attendances.report') }}" class="btn btn-info ms-2">
                            <i class="fas fa-chart-line"></i> Report
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Employee</th>
                                    <th>Date</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Hours Worked</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $attendance)
                                <tr>
                                    <td>{{ $attendance->id }}</td>
                                    <td>
                                        <a href="{{ route('employees.show', $attendance->employee_id) }}">
                                            {{ $attendance->employee->getFullName() }}
                                        </a>
                                    </td>
                                    <td>{{ $attendance->date->format('d/m/Y') }}</td>
                                    <td>{{ $attendance->getCheckInFormatted() }}</td>
                                    <td>{{ $attendance->getCheckOutFormatted() }}</td>
                                    <td>{{ $attendance->hours_worked ?? 0 }} hrs</td>
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
                                    <td>
                                        <a href="{{ route('attendances.show', $attendance) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('update', $attendance)
                                        <a href="{{ route('attendances.edit', $attendance) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('delete', $attendance)
                                        <form method="POST" action="{{ route('attendances.destroy', $attendance) }}" class="d-inline" 
                                              onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $attendances->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection