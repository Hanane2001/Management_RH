@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Payroll Management</h1>
    
    <div class="mb-3">
        @can('create', App\Models\Payroll::class)
            <a href="{{ route('payrolls.create') }}" class="btn btn-primary">+ Create Payroll</a>
        @endcan
        <a href="{{ route('payrolls.export') }}" class="btn btn-success">Export CSV</a>
        
        @can('create', App\Models\Payroll::class)
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#generateModal">
                Generate Payrolls
            </button>
        @endcan
    </div>
    
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('payrolls.index') }}" class="row">
                <div class="col-md-4">
                    <label>Month</label>
                    <select name="month" class="form-control">
                        @foreach($months as $key => $monthName)
                            <option value="{{ $key }}" {{ $month == $key ? 'selected' : '' }}>
                                {{ $monthName }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Year</label>
                    <select name="year" class="form-control">
                        @foreach($years as $yearValue)
                            <option value="{{ $yearValue }}" {{ $year == $yearValue ? 'selected' : '' }}>
                                {{ $yearValue }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary form-control">Filter</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Department</th>
                            <th>Base Salary</th>
                            <th>Overtime</th>
                            <th>Bonuses</th>
                            <th>Allowances</th>
                            <th>Deductions</th>
                            <th>Net Pay</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payrolls as $payroll)
                        <tr>
                            <td>{{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</td>
                            <td>{{ $payroll->employee->department->name ?? 'N/A' }}</td>
                            <td>{{ number_format($payroll->base_salary, 2) }} DH</td>
                            <td>{{ $payroll->overtime_hours }}h</td>
                            <td>{{ number_format($payroll->bonuses, 2) }} DH</td>
                            <td>{{ number_format($payroll->allowances, 2) }} DH</td>
                            <td>{{ number_format($payroll->deductions, 2) }} DH</td>
                            <td class="fw-bold">{{ number_format($payroll->net_pay, 2) }} DH</td>
                            <td>{!! $payroll->getStatusBadge() !!}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('payrolls.show', $payroll) }}" class="btn btn-sm btn-info">View</a>
                                    @can('update', $payroll)
                                        <a href="{{ route('payrolls.edit', $payroll) }}" class="btn btn-sm btn-warning">Edit</a>
                                    @endcan
                                    <a href="{{ route('payrolls.pdf', $payroll) }}" class="btn btn-sm btn-secondary">PDF</a>
                                    @if($payroll->canBeApproved())
                                        <form action="{{ route('payrolls.approve', $payroll) }}" method="POST" style="display:inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                    @endif
                                    @if($payroll->canBePaid())
                                        <form action="{{ route('payrolls.mark-paid', $payroll) }}" method="POST" style="display:inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">Mark Paid</button>
                                        </form>
                                    @endif
                                    @can('delete', $payroll)
                                        <form action="{{ route('payrolls.destroy', $payroll) }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this payroll?')">Delete</button>
                                        </form>
                                    @endcan
                                </div>
                              </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No payroll records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $payrolls->links() }}
        </div>
    </div>
</div>

<!-- Generate Modal -->
@can('create', App\Models\Payroll::class)
<div class="modal fade" id="generateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('payrolls.generate-all') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Generate Payrolls</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Month</label>
                        <select name="month" class="form-control" required>
                            @foreach($months as $key => $monthName)
                                <option value="{{ $key }}" {{ $month == $key ? 'selected' : '' }}>
                                    {{ $monthName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Year</label>
                        <select name="year" class="form-control" required>
                            @foreach($years as $yearValue)
                                <option value="{{ $yearValue }}" {{ $year == $yearValue ? 'selected' : '' }}>
                                    {{ $yearValue }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="alert alert-info">
                        This will generate payrolls for all employees with active contracts.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
@endsection