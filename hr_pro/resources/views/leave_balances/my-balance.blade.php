@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">My Leave Balance</h1>
    
    @if($currentBalance)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4>Current Year - {{ $currentBalance->year }}</h4>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="alert alert-info">
                            <h5>Total Days</h5>
                            <h2 class="display-4">{{ $currentBalance->total_days }}</h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-warning">
                            <h5>Used Days</h5>
                            <h2 class="display-4">{{ $currentBalance->used_days }}</h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-success">
                            <h5>Remaining</h5>
                            <h2 class="display-4">{{ $currentBalance->remaining_days }}</h2>
                        </div>
                    </div>
                </div>
                
                <div class="progress mt-3" style="height: 35px;">
                    <div class="progress-bar bg-{{ $currentBalance->getUsedPercentage() > 80 ? 'danger' : ($currentBalance->getUsedPercentage() > 50 ? 'warning' : 'success') }}" 
                         role="progressbar" 
                         style="width: {{ $currentBalance->getUsedPercentage() }}%">
                        {{ number_format($currentBalance->getUsedPercentage(), 1) }}% Used
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-info text-white">
                <h4>History</h4>
            </div>
            <div class="card-body">
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
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            No leave balance found for {{ date('Y') }}. Please contact your administrator.
        </div>
    @endif
</div>
@endsection