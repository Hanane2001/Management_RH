@extends('layouts.app')

@section('title', 'Payroll Details')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Payroll Details - {{ $payroll->getMonthName() }} {{ $payroll->year }}</h3>
                    <a href="{{ route('payrolls.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Employee</th>
                                    <td>{{ $payroll->employee->getFullName() }}</a>
                                </a>
                                <tr>
                                    <th>Department</th>
                                    <td>{{ $payroll->employee->department->name ?? 'N/A' }}</a>
                                </a>
                                <tr>
                                    <th>Position</th>
                                    <td>{{ $payroll->employee->contracts->first()->position ?? 'N/A' }}</a>
                                </a>
                                <tr>
                                    <th>Status</th>
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
                                </a>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Month/Year</th>
                                    <td>{{ $payroll->getMonthName() }} {{ $payroll->year }}</a>
                                </a>
                                <tr>
                                    <th>Created Date</th>
                                    <td>{{ $payroll->created_at->format('d/m/Y H:i') }}</a>
                                </a>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $payroll->updated_at->format('d/m/Y H:i') }}</a>
                                </a>
                            </table>
                        </div>
                    </div>
                    
                    <h5 class="mt-4">Salary Breakdown</h5>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="40%">Base Salary</th>
                                <td>{{ number_format($payroll->base_salary, 2) }} DH</a>
                                <td class="text-muted">Fixed monthly salary</a>
                            </tr>
                            <tr>
                                <th>Overtime Hours</th>
                                <td>{{ $payroll->overtime_hours }} hours</a>
                                <td class="text-muted">Paid at 1.5x rate</a>
                            </tr>
                            <tr>
                                <th>Bonuses</th>
                                <td>{{ number_format($payroll->bonuses, 2) }} DH</a>
                                <td class="text-muted">Performance bonuses</a>
                            </tr>
                            <tr>
                                <th>Allowances</th>
                                <td>{{ number_format($payroll->allowances, 2) }} DH</a>
                                <td class="text-muted">Transport, housing, etc.</a>
                            </tr>
                            <tr>
                                <th>Gross Salary</th>
                                <td><strong>{{ number_format($payroll->getTotalSalary(), 2) }} DH</strong></a>
                                <td class="text-muted">Before deductions</a>
                            </tr>
                            <tr>
                                <th>Deductions</th>
                                <td>{{ number_format($payroll->deductions, 2) }} DH</a>
                                <td class="text-muted">Taxes, social security, etc.</a>
                            </tr>
                            <tr>
                                <th class="bg-success text-white">Net Pay</th>
                                <td class="bg-success text-white"><strong>{{ number_format($payroll->net_pay, 2) }} DH</strong></a>
                                <td class="bg-success text-white">Amount to be paid</a>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        @can('update', $payroll)
                        <a href="{{ route('payrolls.edit', $payroll) }}" class="btn btn-warning">Edit</a>
                        @endcan
                        @if($payroll->status == 'generated' && (auth()->user()->isAdmin() || auth()->user()->isManager()))
                        <form method="POST" action="{{ route('payrolls.approve', $payroll) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success">Approve Payroll</button>
                        </form>
                        @endif
                        @if($payroll->status == 'approved' && auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('payrolls.mark-paid', $payroll) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary">Mark as Paid</button>
                        </form>
                        @endif
                        @can('delete', $payroll)
                        <form method="POST" action="{{ route('payrolls.destroy', $payroll) }}" class="d-inline" 
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection