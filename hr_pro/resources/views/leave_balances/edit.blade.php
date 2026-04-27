@extends('layouts.app')

@section('title', 'Edit Leave Balance')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Leave Balance for {{ $leaveBalance->employee->getFullName() }}</h3>
                    <a href="{{ route('leave-balances.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('leave-balances.update', $leaveBalance) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Employee *</label>
                            <select class="form-control @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" required>
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id', $leaveBalance->employee_id) == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->getFullName() }} ({{ $employee->email }})
                                </option>
                                @endforeach
                            </select>
                            @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="year" class="form-label">Year *</label>
                                <input type="number" class="form-control @error('year') is-invalid @enderror" 
                                       id="year" name="year" value="{{ old('year', $leaveBalance->year) }}" required>
                                @error('year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="total_days" class="form-label">Total Days *</label>
                                <input type="number" class="form-control @error('total_days') is-invalid @enderror" 
                                       id="total_days" name="total_days" value="{{ old('total_days', $leaveBalance->total_days) }}" required>
                                @error('total_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="used_days" class="form-label">Used Days *</label>
                                <input type="number" class="form-control @error('used_days') is-invalid @enderror" 
                                       id="used_days" name="used_days" value="{{ old('used_days', $leaveBalance->used_days) }}" required>
                                @error('used_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Remaining Days</label>
                                <input type="text" class="form-control" id="remaining_display" readonly disabled>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Leave Balance</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function calculateRemaining() {
        let total = parseInt(document.getElementById('total_days').value) || 0;
        let used = parseInt(document.getElementById('used_days').value) || 0;
        let remaining = total - used;
        document.getElementById('remaining_display').value = remaining + ' days';
        if (remaining < 0) {
            document.getElementById('remaining_display').classList.add('text-danger');
        }
    }
    
    document.getElementById('total_days').addEventListener('input', calculateRemaining);
    document.getElementById('used_days').addEventListener('input', calculateRemaining);
    calculateRemaining();
</script>
@endpush
@endsection