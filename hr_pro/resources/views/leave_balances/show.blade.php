@extends('layouts.app')

@section('title', 'Leave Balance Details')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Leave Balance Details</h3>
                    <a href="{{ route('leave-balances.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Employee</th>
                            <td>{{ $leaveBalance->employee->getFullName() }} </a>
                        </a>
                        <tr>
                            <th>Year</th>
                            <td>{{ $leaveBalance->year }} </a>
                        </a>
                        <tr>
                            <th>Total Days</th>
                            <td>{{ $leaveBalance->total_days }} </a>
                        </a>
                        <tr>
                            <th>Used Days</th>
                            <td>{{ $leaveBalance->used_days }} </a>
                        </a>
                        <tr>
                            <th>Remaining Days</th>
                            <td><strong class="text-{{ $leaveBalance->remaining_days < 5 ? 'danger' : 'success' }}">{{ $leaveBalance->remaining_days }}</strong> </a>
                        </a>
                        <tr>
                            <th>Usage Percentage</th>
                            <td>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-{{ $leaveBalance->getUsedPercentage() > 80 ? 'danger' : ($leaveBalance->getUsedPercentage() > 50 ? 'warning' : 'success') }}" 
                                         style="width: {{ $leaveBalance->getUsedPercentage() }}%">
                                        {{ number_format($leaveBalance->getUsedPercentage(), 1) }}%
                                    </div>
                                </div>
                            </a>
                        </a>
                    </table>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        @can('update', $leaveBalance)
                        <a href="{{ route('leave-balances.edit', $leaveBalance) }}" class="btn btn-warning">Edit Balance</a>
                        @endcan
                        @can('addDays', $leaveBalance)
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDaysModal">
                            <i class="fas fa-plus-circle"></i> Add Days
                        </button>
                        @endcan
                        @can('delete', $leaveBalance)
                        <form method="POST" action="{{ route('leave-balances.destroy', $leaveBalance) }}" class="d-inline" 
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete Balance</button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@can('addDays', $leaveBalance)
<!-- Add Days Modal -->
<div class="modal fade" id="addDaysModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Days to Balance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('leave-balances.add-days', $leaveBalance) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="days" class="form-label">Number of Days to Add</label>
                        <input type="number" class="form-control" name="days" min="1" required>
                        <small class="text-muted">Current remaining: {{ $leaveBalance->remaining_days }} days</small>
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
@endsection