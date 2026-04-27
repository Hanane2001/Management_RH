@extends('layouts.app')

@section('title', 'Payrolls')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Payroll Management</h3>
                    <div class="float-end">
                        <form method="GET" action="{{ route('payrolls.index') }}" class="d-inline">
                            <div class="input-group">
                                <select name="month" class="form-control" style="width: auto;">
                                    @foreach($months as $key => $monthName)
                                    <option value="{{ $key }}" {{ $month == $key ? 'selected' : '' }}>
                                        {{ $monthName }}
                                    </option>
                                    @endforeach
                                </select>
                                <select name="year" class="form-control" style="width: auto;">
                                    @foreach($years as $yearOption)
                                    <option value="{{ $yearOption }}" {{ $year == $yearOption ? 'selected' : '' }}>
                                        {{ $yearOption }}
                                    </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </form>
                        @can('create', App\Models\Payroll::class)
                        <a href="{{ route('payrolls.create') }}" class="btn btn-primary ms-2">
                            <i class="fas fa-plus"></i> Add Payroll
                        </a>
                        <button type="button" class="btn btn-info ms-2" data-bs-toggle="modal" data-bs-target="#generateAllModal">
                            <i class="fas fa-sync"></i> Generate All
                        </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Employee</th>
                                    <th>Department</th>
                                    <th>Base Salary</th>
                                    <th>Bonuses</th>
                                    <th>Deductions</th>
                                    <th>Net Pay</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payrolls as $payroll)
                                <tr>
                                    <td>{{ $payroll->id }}</a></td>
                                    <td>
                                        <a href="{{ route('employees.show', $payroll->employee_id) }}">
                                            {{ $payroll->employee->getFullName() }}
                                        </a>
                                    </a></td>
                                    <td>{{ $payroll->employee->department->name ?? 'N/A' }}</a></td>
                                    <td>{{ number_format($payroll->base_salary, 2) }} DH</a></td>
                                    <td>{{ number_format($payroll->bonuses, 2) }} DH</a></td>
                                    <td>{{ number_format($payroll->deductions, 2) }} DH</a></td>
                                    <td><strong>{{ number_format($payroll->net_pay, 2) }} DH</strong></a></td>
                                    <td>
                                        @if($payroll->status == 'draft')
                                            <span class="badge bg-secondary">Draft</span>
                                        @elseif($payroll->status == 'generated')
                                            <span class="badge bg-info">Generated</span>
                                        @elseif($payroll->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-primary">Paid</span>
                                        @endif
                                    </a>
                                    <td>
                                        <a href="{{ route('payrolls.show', $payroll) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('update', $payroll)
                                        <a href="{{ route('payrolls.edit', $payroll) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan
                                        @if($payroll->status == 'generated' && (auth()->user()->isAdmin() || auth()->user()->isManager()))
                                        <form method="POST" action="{{ route('payrolls.approve', $payroll) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                        @endif
                                        @if($payroll->status == 'approved' && auth()->user()->isAdmin())
                                        <form method="POST" action="{{ route('payrolls.mark-paid', $payroll) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">Mark Paid</button>
                                        </form>
                                        @endif
                                    </a>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $payrolls->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Generate All Modal -->
<div class="modal fade" id="generateAllModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generate Payroll for All Employees</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('payrolls.generate-all') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="month" class="form-label">Month</label>
                        <select name="month" class="form-control" required>
                            @foreach($months as $key => $monthName)
                            <option value="{{ $key }}" {{ $key == $month ? 'selected' : '' }}>
                                {{ $monthName }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Year</label>
                        <select name="year" class="form-control" required>
                            @foreach($years as $yearOption)
                            <option value="{{ $yearOption }}" {{ $yearOption == $year ? 'selected' : '' }}>
                                {{ $yearOption }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        This will generate payroll for all employees with active contracts. Existing payroll records will be skipped.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Generate All</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection