@extends('layouts.app')

@section('title', 'Request Leave')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Request Leave</h3>
                    <a href="{{ route('leaves.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <strong>Your Leave Balance:</strong> {{ $balance->remaining_days }} days remaining
                    </div>
                    <form method="POST" action="{{ route('leaves.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="type" class="form-label">Leave Type *</label>
                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="paid" {{ old('type') == 'paid' ? 'selected' : '' }}>Paid Leave</option>
                                <option value="sick" {{ old('type') == 'sick' ? 'selected' : '' }}>Sick Leave</option>
                                <option value="unpaid" {{ old('type') == 'unpaid' ? 'selected' : '' }}>Unpaid Leave</option>
                                <option value="exceptional" {{ old('type') == 'exceptional' ? 'selected' : '' }}>Exceptional Leave</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Start Date *</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">End Date *</label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                       id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason</label>
                            <textarea class="form-control @error('reason') is-invalid @enderror" 
                                      id="reason" name="reason" rows="3">{{ old('reason') }}</textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Submit Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('start_date').addEventListener('change', calculateDuration);
    document.getElementById('end_date').addEventListener('change', calculateDuration);
    
    function calculateDuration() {
        var start = new Date(document.getElementById('start_date').value);
        var end = new Date(document.getElementById('end_date').value);
        
        if (start && end && start <= end) {
            var diffTime = Math.abs(end - start);
            var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            // You can add a display for duration here if needed
        }
    }
</script>
@endpush
@endsection