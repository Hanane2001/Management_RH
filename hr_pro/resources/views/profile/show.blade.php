@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Profile Information</h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="display-1">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <h4>{{ $user->getFullName() }}</h4>
                        <p class="text-muted">{{ ucfirst($user->role->name ?? 'N/A') }}</p>
                        <p class="text-muted">{{ $user->department->name ?? 'No Department' }}</p>
                    </div>
                    <hr>
                    <div class="text-start">
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
                        <p><strong>Birth Date:</strong> {{ $user->birth_date ? $user->birth_date->format('d/m/Y') : 'N/A' }}</p>
                        <p><strong>Address:</strong> {{ $user->address ?? 'N/A' }}</p>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                        <a href="{{ route('profile.change-password') }}" class="btn btn-warning">
                            <i class="fas fa-key"></i> Change Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Statistics</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h5>Total Leaves</h5>
                                    <h3>{{ $stats['total_leaves'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h5>Approved Leaves</h5>
                                    <h3>{{ $stats['approved_leaves'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h5>Pending Leaves</h5>
                                    <h3>{{ $stats['pending_leaves'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h5>Contracts</h5>
                                    <h3>{{ $stats['contracts_count'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if(isset($stats['leave_balance']))
                    <div class="mt-3">
                        <h5>Leave Balance</h5>
                        @if($stats['total_leave_days'] > 0)
                            <div class="progress mb-2" style="height: 30px;">
                                <div class="progress-bar bg-success" style="width: {{ ($stats['used_leave_days'] / $stats['total_leave_days']) * 100 }}%">
                                    Used: {{ $stats['used_leave_days'] }} days
                                </div>
                                <div class="progress-bar bg-warning" style="width: {{ ($stats['leave_balance'] / $stats['total_leave_days']) * 100 }}%">
                                    Remaining: {{ $stats['leave_balance'] }} days
                                </div>
                            </div>
                            <p>Total: {{ $stats['total_leave_days'] }} days</p>
                        @else
                            <div class="alert alert-info">
                                <p>No leave days allocated yet.</p>
                                <p>Used: {{ $stats['used_leave_days'] }} days</p>
                                <p>Remaining: {{ $stats['leave_balance'] }} days</p>
                            </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h4>Recent Activities</h4>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @forelse($user->leaves()->latest()->limit(5)->get() as $leave)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ ucfirst($leave->type) }} Leave</strong><br>
                                    <small>{{ $leave->start_date->format('d/m/Y') }} - {{ $leave->end_date->format('d/m/Y') }}</small>
                                </div>
                                <span class="badge bg-{{ $leave->status == 'pending' ? 'warning' : ($leave->status == 'approved' ? 'success' : 'danger') }}">
                                    {{ ucfirst($leave->status) }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="list-group-item text-center text-muted">
                            No recent activities
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection