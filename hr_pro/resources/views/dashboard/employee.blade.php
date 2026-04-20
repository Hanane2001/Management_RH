@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">My Dashboard</h1>
    
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
            <div class="card-header bg-primary text-white">My Active Contract</div>
            <div class="card-body">
                <p><strong>Position:</strong> {{ $stats['active_contract']->position }}</p>
                <p><strong>Salary:</strong> {{ number_format($stats['active_contract']->base_salary, 2) }} DH</p>
                <p><strong>Type:</strong> {{ $stats['active_contract']->type }}</p>
            </div>
        </div>
    @endif
    
    <div class="card">
        <div class="card-header bg-info text-white">My Recent Leaves</div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($my_leaves as $leave)
                    <li class="list-group-item">
                        {{ $leave->type }} - 
                        {{ $leave->start_date->format('d/m/Y') }} → {{ $leave->end_date->format('d/m/Y') }}
                        <span class="badge bg-{{ $leave->status == 'pending' ? 'warning' : ($leave->status == 'approved' ? 'success' : 'danger') }}">
                            {{ $leave->status }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h5>📊 My Evaluations</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <h3>{{ $stats['my_evaluations'] ?? 0 }}</h3>
                    <p>Total Evaluations</p>
                </div>
                <div class="col-md-4 text-center">
                    <h3>{{ number_format($stats['my_average_score'] ?? 0, 1) }}%</h3>
                    <p>Average Score</p>
                </div>
                <div class="col-md-4 text-center">
                    <a href="{{ route('evaluations.index') }}" class="btn btn-sm btn-primary">View My Evaluations</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection