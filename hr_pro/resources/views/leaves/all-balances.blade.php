@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">All Leave Balances - {{ date('Y') }}</h1>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Department</th>
                            <th>Total</th>
                            <th>Used</th>
                            <th>Remaining</th>
                            <th>Usage</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($balances as $balance)
                        <tr>
                            <td>{{ $balance->employee->first_name }} {{ $balance->employee->last_name }}</td>
                            <td>{{ $balance->employee->department->name ?? 'N/A' }}</td>
                            <td>{{ $balance->total_days }}</td>
                            <td>{{ $balance->used_days }}</td>
                            <td class="{{ $balance->remaining_days < 5 ? 'text-danger fw-bold' : 'text-success' }}">
                                {{ $balance->remaining_days }}
                            </td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ $balance->getUsedPercentage() }}%">
                                        {{ number_format($balance->getUsedPercentage(), 1) }}%
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($balance->remaining_days == 0)
                                    <span class="badge bg-danger">Exhausted</span>
                                @elseif($balance->remaining_days < 5)
                                    <span class="badge bg-warning">Low</span>
                                @else
                                    <span class="badge bg-success">Good</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $balances->links() }}
        </div>
    </div>
</div>
@endsection