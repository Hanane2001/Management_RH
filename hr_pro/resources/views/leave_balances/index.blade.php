@extends('layouts.app')

@section('title', 'Leave Balances')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Leave Balances Management</h3>
                    @can('create', App\Models\LeaveBalance::class)
                    <div class="float-end">
                        <form method="POST" action="{{ route('leave-balances.initialize') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-info" onclick="return confirm('Initialize balances for current year?')">
                                <i class="fas fa-sync"></i> Initialize Year
                            </button>
                        </form>
                        <a href="{{ route('leave-balances.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Balance
                        </a>
                    </div>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Employee</th>
                                    <th>Year</th>
                                    <th>Total Days</th>
                                    <th>Used Days</th>
                                    <th>Remaining Days</th>
                                    <th>Usage</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($balances as $balance)
                                <tr>
                                    <td>{{ $balance->id }}</a></td>
                                    <td><a href="{{ route('employees.show', $balance->employee_id) }}">
                                        {{ $balance->employee->getFullName() }}
                                    </a></td>
                                    <td>{{ $balance->year }}</a></td>
                                    <td>{{ $balance->total_days }}</a></td>
                                    <td>{{ $balance->used_days }}</a></td>
                                    <td><strong>{{ $balance->remaining_days }}</strong></a></td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-{{ $balance->getUsedPercentage() > 80 ? 'danger' : ($balance->getUsedPercentage() > 50 ? 'warning' : 'success') }}" 
                                                 style="width: {{ $balance->getUsedPercentage() }}%">
                                                {{ number_format($balance->getUsedPercentage(), 1) }}%
                                            </div>
                                        </div>
                                    </a>
                                    <td>
                                        <a href="{{ route('leave-balances.show', $balance) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('update', $balance)
                                        <a href="{{ route('leave-balances.edit', $balance) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('addDays', $balance)
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addDaysModal{{ $balance->id }}">
                                            <i class="fas fa-plus-circle"></i> Add Days
                                        </button>
                                        @endcan
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

@foreach($balances as $balance)
@can('addDays', $balance)
<!-- Add Days Modal -->
<div class="modal fade" id="addDaysModal{{ $balance->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Days to Balance for {{ $balance->employee->getFullName() }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('leave-balances.add-days', $balance) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="days" class="form-label">Number of Days to Add</label>
                        <input type="number" class="form-control" name="days" min="1" required>
                        <small class="text-muted">Current remaining: {{ $balance->remaining_days }} days</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Days</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
@endforeach
@endsection