@extends('layouts.app')

@section('title', 'Employee Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Welcome, {{ auth()->user()->getFullName() }}!</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card stats-card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Leave Balance</h5>
                    <h2>{{ $stats['leave_balance'] }} / {{ $stats['total_leave_days'] }}</h2>
                    <small>Days remaining</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stats-card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Leaves</h5>
                    <h2>{{ $stats['my_leaves'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stats-card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Approved Leaves</h5>
                    <h2>{{ $stats['approved_leaves'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stats-card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Pending Leaves</h5>
                    <h2>{{ $stats['pending_leaves'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>My Recent Leaves</h5>
                    <a href="{{ route('leaves.create') }}" class="btn btn-sm btn-primary float-end">Request Leave</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Dates</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($my_leaves as $leave)
                                <tr>
                                    <td>{{ ucfirst($leave->type) }}</td>
                                    <td>{{ $leave->start_date->format('d/m/Y') }} - {{ $leave->end_date->format('d/m/Y') }}</td>
                                    <td>{{ $leave->duration }} days</td>
                                    <td>
                                        @if($leave->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($leave->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
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
                    <h5>My Contracts</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Position</th>
                                    <th>Type</th>
                                    <th>Start Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($my_contracts as $contract)
                                <tr>
                                    <td>{{ $contract->position }}</td>
                                    <td>{{ ucfirst($contract->type) }}</td>
                                    <td>{{ $contract->start_date->format('d/m/Y') }}</td>
                                    <td>
                                        @if($contract->isActive())
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Expired</span>
                                        @endif
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

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <form method="POST" action="{{ route('attendances.check-in') }}">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 mb-2">
                                <i class="fas fa-sign-in-alt"></i> Check In
                            </button>
                        </form>
                        <form method="POST" action="{{ route('attendances.check-out') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100 mb-2">
                                <i class="fas fa-sign-out-alt"></i> Check Out
                            </button>
                        </form>
                        <a href="{{ route('leaves.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-calendar-plus"></i> Request Leave
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>My Performance</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <h3>{{ number_format($stats['my_average_score'] ?? 0, 1) }}%</h3>
                        <p>Average Evaluation Score</p>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width: {{ $stats['my_average_score'] ?? 0 }}%">
                                {{ number_format($stats['my_average_score'] ?? 0, 1) }}%
                            </div>
                        </div>
                        <p class="mt-3">Total Evaluations: {{ $stats['my_evaluations'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection