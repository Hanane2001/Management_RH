@extends('layouts.app')

@section('title', 'Leave Requests')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Leave Requests</h3>
                    <a href="{{ route('leaves.create') }}" class="btn btn-primary float-end">
                        <i class="fas fa-plus"></i> Request Leave
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    @can('manage-leaves')
                                    <th>Employee</th>
                                    @endcan
                                    <th>Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                    @can('process', App\Models\Leave::class)
                                    <th>Actions</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leaves as $leave)
                                <tr>
                                    <td>{{ $leave->id }}</td>
                                    @can('manage-leaves')
                                    <td>{{ $leave->employee->getFullName() }}</td>
                                    @endcan
                                    <td>{{ ucfirst($leave->type) }}</td>
                                    <td>{{ $leave->start_date->format('d/m/Y') }}</td>
                                    <td>{{ $leave->end_date->format('d/m/Y') }}</td>
                                    <td>{{ $leave->duration }} days</td>
                                    <td>
                                        @if($leave->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($leave->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    @can('process', $leave)
                                        <td>
                                            @if($leave->isPending())
                                            <form method="POST" action="{{ route('leaves.approve', $leave) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('leaves.reject', $leave) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-times"></i> Reject
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    @endcan
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $leaves->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection