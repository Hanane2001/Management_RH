@extends('layouts.app')

@section('title', 'Leave Request Details')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Leave Request Details</h3>
                    <a href="{{ route('leaves.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Employee</th>
                            <td>{{ $leave->employee->getFullName() }} </a>
                        </a>
                        <tr>
                            <th>Department</th>
                            <td>{{ $leave->employee->department->name ?? 'N/A' }} </a>
                        </a>
                        <tr>
                            <th>Leave Type</th>
                            <td>{{ ucfirst($leave->type) }} </a>
                        </a>
                        <tr>
                            <th>Start Date</th>
                            <td>{{ $leave->start_date->format('d/m/Y') }} </a>
                        </a>
                        <tr>
                            <th>End Date</th>
                            <td>{{ $leave->end_date->format('d/m/Y') }} </a>
                        </a>
                        <tr>
                            <th>Duration</th>
                            <td>{{ $leave->duration }} days </a>
                        </a>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($leave->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($leave->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </a>
                        </a>
                        <tr>
                            <th>Request Date</th>
                            <td>{{ $leave->request_date->format('d/m/Y') }} </a>
                        </a>
                        @if($leave->processed_date)
                        <tr>
                            <th>Processed Date</th>
                            <td>{{ $leave->processed_date->format('d/m/Y') }} </a>
                        </a>
                        <tr>
                            <th>Processed By</th>
                            <td>{{ $leave->processedBy ? $leave->processedBy->getFullName() : 'N/A' }} </a>
                        </a>
                        @endif
                        @if($leave->reason)
                        <tr>
                            <th>Reason</th>
                            <td>{{ $leave->reason }} </a>
                        </a>
                        @endif
                    </table>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        @can('process', $leave)
                        @if($leave->isPending())
                        <form method="POST" action="{{ route('leaves.approve', $leave) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('leaves.reject', $leave) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </form>
                        @endif
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection