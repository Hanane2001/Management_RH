@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Leave Request Details</h1>
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Employee:</strong> {{ $leave->employee->first_name }} {{ $leave->employee->last_name }}</p>
                    <p><strong>Type:</strong> 
                        @if($leave->type == 'paid') Paid Leave
                        @elseif($leave->type == 'sick') Sick Leave
                        @elseif($leave->type == 'unpaid') Unpaid Leave
                        @else Exceptional Leave
                        @endif
                    </p>
                    <p><strong>Duration:</strong> {{ $leave->duration }} day(s)</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Start Date:</strong> {{ $leave->start_date->format('d/m/Y') }}</p>
                    <p><strong>End Date:</strong> {{ $leave->end_date->format('d/m/Y') }}</p>
                    <p><strong>Request Date:</strong> {{ $leave->request_date->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            
            <p><strong>Reason:</strong> {{ $leave->reason ?? 'No reason provided' }}</p>
            
            <p><strong>Status:</strong>
                @if($leave->status == 'pending')
                    <span class="badge bg-warning">Pending</span>
                @elseif($leave->status == 'approved')
                    <span class="badge bg-success">Approved</span>
                @else
                    <span class="badge bg-danger">Rejected</span>
                @endif
            </p>
            
            @if($leave->processed_date)
                <p><strong>Processed on:</strong> {{ $leave->processed_date->format('d/m/Y H:i') }}</p>
                <p><strong>Processed by:</strong> {{ $leave->processedBy->first_name ?? '' }} {{ $leave->processedBy->last_name ?? '' }}</p>
            @endif
        </div>
    </div>
    
    <div class="mt-3">
        <a href="{{ route('leaves.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection