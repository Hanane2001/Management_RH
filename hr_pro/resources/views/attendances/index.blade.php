@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Attendance Management</h1>
    
    <div class="mb-3">
        @can('create', App\Models\Attendance::class)
            <a href="{{ route('attendances.create') }}" class="btn btn-primary">+ Add Attendance</a>
        @endcan
        <a href="{{ route('attendances.report') }}" class="btn btn-info">Reports</a>
        <a href="{{ route('attendances.export') }}" class="btn btn-success">Export CSV</a>
        
        @if(auth()->user()->isEmployee())
            <form method="POST" action="{{ route('attendances.check-in') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-secondary">Check In</button>
            </form>
            <form method="POST" action="{{ route('attendances.check-out') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-secondary">Check Out</button>
            </form>
        @endif
    </div>
    
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('attendances.index') }}" class="row">
                <div class="col-md-4">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control" value="{{ $date }}">
                </div>
                <div class="col-md-4">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary form-control">Filter</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Date</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Hours</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->employee->first_name }} {{ $attendance->employee->last_name }}</td>
                            <td>{{ $attendance->date->format('d/m/Y') }}</td>
                            <td>{{ $attendance->getCheckInFormatted() }}</td>
                            <td>{{ $attendance->getCheckOutFormatted() }}</td>
                            <td>{{ $attendance->hours_worked ?? '-' }}</td>
                            <td>{!! $attendance->getStatusBadge() !!}</td>
                            <td>
                                <a href="{{ route('attendances.show', $attendance) }}" class="btn btn-sm btn-info">View</a>
                                @can('update', $attendance)
                                    <a href="{{ route('attendances.edit', $attendance) }}" class="btn btn-sm btn-warning">Edit</a>
                                @endcan
                                @can('delete', $attendance)
                                    <form action="{{ route('attendances.destroy', $attendance) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this attendance?')">Delete</button>
                                    </form>
                                @endcan
                              </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No attendance records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $attendances->links() }}
        </div>
    </div>
</div>
@endsection