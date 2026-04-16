@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Manager Dashboard</h1>
    
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
    
    <div class="row">
        <div class="col-md-12">
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
</div>
@endsection