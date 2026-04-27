@extends('layouts.app')

@section('title', 'Leave Balance Statistics')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Leave Balance Statistics - {{ date('Y') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h5>Total Employees</h5>
                    <h2>{{ $stats['total_employees'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h5>Total Days Allocated</h5>
                    <h2>{{ number_format($stats['total_days_allocated']) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h5>Total Days Used</h5>
                    <h2>{{ number_format($stats['total_days_used']) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h5>Low Balance (&lt;5 days)</h5>
                    <h2>{{ $stats['employees_with_low_balance'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Employees with Critical Balance (&lt;5 days)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Department</th>
                                    <th>Remaining Days</th>
                                    <th>Usage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowBalances as $balance)
                                <tr>
                                    <td>{{ $balance->employee->getFullName() }}</a></td>
                                    <td>{{ $balance->employee->department->name ?? 'N/A' }}</a></td>
                                    <td><span class="text-danger fw-bold">{{ $balance->remaining_days }}</span></a></td>
                                    <td>{{ number_format($balance->getUsedPercentage(), 1) }}%</a></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-success">No employees with critical balance</a>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Balance Overview</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <canvas id="balanceChart" width="400" height="300"></canvas>
                        <div class="mt-3">
                            <p><strong>Employees with Zero Balance:</strong> {{ $stats['employees_with_zero_balance'] }}</p>
                            <p><strong>Average Days per Employee:</strong> {{ number_format($stats['total_days_allocated'] / max($stats['total_balances'], 1), 1) }} days</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('balanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Used Days ({{ $stats['total_days_used'] }})', 'Remaining Days ({{ $stats['total_days_allocated'] - $stats['total_days_used'] }})'],
            datasets: [{
                data: [{{ $stats['total_days_used'] }}, {{ $stats['total_days_allocated'] - $stats['total_days_used'] }}],
                backgroundColor: ['#ffc107', '#28a745'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush