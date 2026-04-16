@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">My Leave Balance</h1>
    
    @if($currentBalance)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4>Year {{ $currentBalance->year }}</h4>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="alert alert-info">
                            <h5>Total</h5>
                            <h2 class="display-4">{{ $currentBalance->total_days }}</h2>
                            <p>days</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-warning">
                            <h5>Used</h5>
                            <h2 class="display-4">{{ $currentBalance->used_days }}</h2>
                            <p>days</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-success">
                            <h5>Remaining</h5>
                            <h2 class="display-4">{{ $currentBalance->remaining_days }}</h2>
                            <p>days</p>
                        </div>
                    </div>
                </div>
                
                <div class="progress mt-3" style="height: 30px;">
                    <div class="progress-bar bg-{{ $currentBalance->getUsedPercentage() > 80 ? 'danger' : ($currentBalance->getUsedPercentage() > 50 ? 'warning' : 'success') }}" 
                         role="progressbar" 
                         style="width: {{ $currentBalance->getUsedPercentage() }}%">
                        {{ number_format($currentBalance->getUsedPercentage(), 1) }}% used
                    </div>
                </div>
            </div>
        </div>
        
        <h3>History</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Year</th>
                        <th>Total</th>
                        <th>Used</th>
                        <th>Remaining</th>
                        <th>Usage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($balances as $balance)
                    <tr>
                        <td>{{ $balance->year }}</td>
                        <td>{{ $balance->total_days }}</td>
                        <td>{{ $balance->used_days }}</td>
                        <td class="{{ $balance->remaining_days < 5 ? 'text-danger fw-bold' : '' }}">
                            {{ $balance->remaining_days }}
                        </td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar" style="width: {{ $balance->getUsedPercentage() }}%">
                                    {{ number_format($balance->getUsedPercentage(), 1) }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-warning">No leave balance found for current year</div>
    @endif
    
    <div class="mt-3">
        <a href="{{ route('leaves.create') }}" class="btn btn-primary">New Leave Request</a>
        <a href="{{ route('leaves.index') }}" class="btn btn-secondary">My Requests</a>
    </div>
</div>
@endsection