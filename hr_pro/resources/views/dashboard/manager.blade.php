@extends('layouts.app')

@section('title', 'Manager Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Manager Dashboard</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card stats-card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Team Members</h5>
                    <h2>{{ $stats['total_employees'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card stats-card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Pending Leaves</h5>
                    <h2>{{ $stats['pending_leaves'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card stats-card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Active Contracts</h5>
                    <h2>{{ $stats['active_contracts'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Team Members</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Position</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_employees as $employee)
                                <tr>
                                    <td>{{ $employee->getFullName() }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->contracts->first()->position ?? 'N/A' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Pending Leave Requests</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Type</th>
                                    <th>Dates</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pending_leaves as $leave)
                                <tr>
                                    <td>{{ $leave->employee->getFullName() }}</td>
                                    <td>{{ ucfirst($leave->type) }}</td>
                                    <td>{{ $leave->start_date->format('d/m/Y') }} - {{ $leave->end_date->format('d/m/Y') }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('leaves.approve', $leave) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('leaves.reject', $leave) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection