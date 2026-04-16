@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">New Leave Request</h1>
    
    <div class="alert alert-info">
        <strong>Available balance:</strong> {{ $balance->remaining_days }} days out of {{ $balance->total_days }}
    </div>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('leaves.store') }}">
                @csrf
                
                <div class="mb-3">
                    <label>Leave Type *</label>
                    <select name="type" class="form-control" required>
                        <option value="">Select type</option>
                        <option value="paid">Paid Leave</option>
                        <option value="sick">Sick Leave</option>
                        <option value="unpaid">Unpaid Leave</option>
                        <option value="exceptional">Exceptional Leave</option>
                    </select>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Start Date *</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>End Date *</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label>Reason (Optional)</label>
                    <textarea name="reason" class="form-control" rows="3" placeholder="Explain the reason for your leave..."></textarea>
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                    <a href="{{ route('leaves.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection