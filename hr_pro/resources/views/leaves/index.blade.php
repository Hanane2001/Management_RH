@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Leave Requests</h1>
    
    <div class="mb-3">
        <a href="{{ route('leaves.create') }}" class="btn btn-primary">+ New Leave Request</a>
        <a href="{{ route('leaves.balance') }}" class="btn btn-info">My Balance</a>
        @can('isManager')
            <a href="{{ route('leaves.all-balances') }}" class="btn btn-secondary">All Balances</a>
        @endcan
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            @canany(['isAdmin', 'isManager'])
                                <th>Employee</th>
                            @endcanany
                            <th>Type</th>
                            <th>Period</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaves as $leave)
                        <tr>
                            <td>{{ $leave->request_date->format('d/m/Y') }}</td>
                            @canany(['isAdmin', 'isManager'])
                                <td>{{ $leave->employee->first_name }} {{ $leave->employee->last_name }}</td>
                            @endcanany
                            <td>
                                @if($leave->type == 'paid') Paid
                                @elseif($leave->type == 'sick') Sick
                                @elseif($leave->type == 'unpaid') Unpaid
                                @else Exceptional
                                @endif
                            </td>
                            <td>{{ $leave->start_date->format('d/m/Y') }} → {{ $leave->end_date->format('d/m/Y') }}</td>
                            <td>{{ $leave->duration }} day(s)</td>
                            <td>
                                @if($leave->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($leave->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                             </td>
                            <td>
                                <a href="{{ route('leaves.show', $leave) }}" class="btn btn-sm btn-info">View</a>
                                @if($leave->isPending() && (auth()->user()->isManager() || auth()->user()->isAdmin()))
                                    <form action="{{ route('leaves.approve', $leave) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                    </form>
                                    <form action="{{ route('leaves.reject', $leave) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                    </form>
                                @endif
                             </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->isAdmin() || auth()->user()->isManager() ? '7' : '6' }}" class="text-center">
                                    No leave requests found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $leaves->links() }}
        </div>
    </div>
</div>
@endsection