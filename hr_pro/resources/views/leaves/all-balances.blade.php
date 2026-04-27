@extends('layouts.app')

@section('title', 'All Leave Balances')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Leave Balances - {{ date('Y') }}</h3>
                    <a href="{{ route('leaves.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Department</th>
                                    <th>Total Days</th>
                                    <th>Used Days</th>
                                    <th>Remaining Days</th>
                                    <th>Usage Rate</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($balances as $balance)
                                <tr>
                                    <td>
                                        <a href="{{ route('employees.show', $balance->employee_id) }}">
                                            {{ $balance->employee->getFullName() }}
                                        </a>
                                    </a></td>
                                    <td>{{ $balance->employee->department->name ?? 'N/A' }}</a></td>
                                    <td>{{ $balance->total_days }}</a></td>
                                    <td>{{ $balance->used_days }}</a></td>
                                    <td>
                                        <strong class="text-{{ $balance->remaining_days < 5 ? 'danger' : ($balance->remaining_days < 10 ? 'warning' : 'success') }}">
                                            {{ $balance->remaining_days }}
                                        </strong>
                                    </a></td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-{{ $balance->getUsedPercentage() > 80 ? 'danger' : ($balance->getUsedPercentage() > 50 ? 'warning' : 'success') }}" 
                                                 style="width: {{ $balance->getUsedPercentage() }}%">
                                                {{ number_format($balance->getUsedPercentage(), 1) }}%
                                            </div>
                                        </div>
                                    </a>
                                    <td>
                                        @if($balance->remaining_days == 0)
                                            <span class="badge bg-danger">Exhausted</span>
                                        @elseif($balance->remaining_days < 5)
                                            <span class="badge bg-warning">Critical</span>
                                        @elseif($balance->remaining_days < 10)
                                            <span class="badge bg-info">Low</span>
                                        @else
                                            <span class="badge bg-success">Good</span>
                                        @endif
                                    </a>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $balances->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection