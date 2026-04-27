@extends('layouts.app')

@section('title', 'My Leave Balance')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Leave Balance History</h3>
                    <a href="{{ route('leaves.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    @if($currentBalance)
                    <div class="text-center mb-4">
                        <div class="display-1 text-primary">{{ $currentBalance->remaining_days }}</div>
                        <h4>Days Remaining in {{ date('Y') }}</h4>
                        <div class="progress mt-3" style="height: 30px;">
                            <div class="progress-bar bg-success" style="width: {{ ($currentBalance->used_days / $currentBalance->total_days) * 100 }}%">
                                Used: {{ $currentBalance->used_days }} days
                            </div>
                            <div class="progress-bar bg-warning" style="width: {{ ($currentBalance->remaining_days / $currentBalance->total_days) * 100 }}%">
                                Remaining: {{ $currentBalance->remaining_days }} days
                            </div>
                        </div>
                        <p class="mt-2">Total: {{ $currentBalance->total_days }} days per year</p>
                    </div>
                    @else
                    <div class="alert alert-info text-center">
                        No leave balance found for current year. Please contact HR.
                    </div>
                    @endif

                    <h5 class="mt-4">Historical Balances</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Year</th>
                                    <th>Total Days</th>
                                    <th>Used Days</th>
                                    <th>Remaining Days</th>
                                    <th>Usage Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($balances as $balance)
                                <tr>
                                    <td>{{ $balance->year }}</a></td>
                                    <td>{{ $balance->total_days }}</a></td>
                                    <td>{{ $balance->used_days }}</a><td>
                                    <td><strong class="text-{{ $balance->remaining_days < 5 ? 'danger' : 'success' }}">
                                        {{ $balance->remaining_days }}
                                    </strong></a></td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-{{ $balance->getUsedPercentage() > 80 ? 'danger' : ($balance->getUsedPercentage() > 50 ? 'warning' : 'success') }}" 
                                                 style="width: {{ $balance->getUsedPercentage() }}%">
                                                {{ number_format($balance->getUsedPercentage(), 1) }}%
                                            </div>
                                        </div>
                                    </a>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No historical data available</a>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection