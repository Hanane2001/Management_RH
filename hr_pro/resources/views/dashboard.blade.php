@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard</h1>
    
    @if(auth()->user()->isAdmin())
        <!-- Admin Dashboard -->
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5>Total Employees</h5>
                        <h2>{{ $stats['total_employees'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5>Active Contracts</h5>
                        <h2>{{ $stats['active_contracts'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5>Pending Leaves</h5>
                        <h2>{{ $stats['pending_leaves'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5>Expiring Contracts</h5>
                        <h2>{{ $stats['expiring_contracts'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Recent Employees</div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($recent_employees as $emp)
                                <li class="list-group-item">{{ $emp->first_name }} {{ $emp->last_name }} - {{ $emp->email }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Pending Leave Requests</div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($pending_leaves as $leave)
                                <li class="list-group-item">
                                    {{ $leave->employee->first_name }} - {{ $leave->type }} 
                                    ({{ $leave->start_date->format('d/m') }} → {{ $leave->end_date->format('d/m') }})
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
    @elseif(auth()->user()->isManager())
        <!-- Manager Dashboard -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5>Team Members</h5>
                        <h2>{{ $stats['total_employees'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5>Pending Approvals</h5>
                        <h2>{{ $stats['pending_leaves'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5>Active Contracts</h5>
                        <h2>{{ $stats['active_contracts'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
        
    @else
        <!-- Employee Dashboard -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5>Leave Balance</h5>
                        <h2>{{ $stats['leave_balance'] }} / {{ $stats['total_leave_days'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5>My Leaves</h5>
                        <h2>{{ $stats['my_leaves'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5>My Contracts</h5>
                        <h2>{{ $stats['my_contracts'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
        
        @if($stats['active_contract'])
            <div class="card mb-3">
                <div class="card-header">My Active Contract</div>
                <div class="card-body">
                    <p><strong>Position:</strong> {{ $stats['active_contract']->position }}</p>
                    <p><strong>Salary:</strong> {{ $stats['active_contract']->base_salary }} DH</p>
                    <p><strong>Type:</strong> {{ $stats['active_contract']->type }}</p>
                </div>
            </div>
        @endif
    @endif
</div>
@endsection