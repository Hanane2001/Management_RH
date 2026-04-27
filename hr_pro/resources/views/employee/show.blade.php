@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Employee Details: {{ $employee->getFullName() }}</h3>
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">First Name</th>
                                    <td>{{ $employee->first_name }}</td>
                                </tr>
                                <tr>
                                    <th>Last Name</th>
                                    <td>{{ $employee->last_name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $employee->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $employee->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Department</th>
                                    <td>{{ $employee->department->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td>{{ ucfirst($employee->role->name ?? 'N/A') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Birth Date</th>
                                    <td>{{ $employee->birth_date ? $employee->birth_date->format('d/m/Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $employee->address ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>ID Number</th>
                                    <td>{{ $employee->id_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Social Security Number</th>
                                    <td>{{ $employee->social_security_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($employee->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Leave Balance</th>
                                    <td>{{ $currentBalance ? $currentBalance->remaining_days : 0 }} days remaining</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h5>Total Leaves</h5>
                                    <h3>{{ $totalLeaves }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h5>Approved Leaves</h5>
                                    <h3>{{ $approvedLeaves }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h5>Pending Leaves</h5>
                                    <h3>{{ $pendingLeaves }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($activeContract)
                    <div class="mt-4">
                        <h5>Active Contract</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th width="20%">Position</th>
                                <td>{{ $activeContract->position }}</td>
                                <th width="20%">Type</th>
                                <td>{{ ucfirst($activeContract->type) }}</td>
                            </tr>
                            <tr>
                                <th>Base Salary</th>
                                <td>{{ number_format($activeContract->base_salary, 2) }} DH</td>
                                <th>Start Date</th>
                                <td>{{ $activeContract->start_date->format('d/m/Y') }}</td>
                            </tr>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection