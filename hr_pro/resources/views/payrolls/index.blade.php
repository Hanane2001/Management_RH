@extends('layouts.app')

@section('title', 'Payrolls')

@section('content')
<style>
    /* Header */
    .page-header {
        margin-bottom: 24px;
    }
    
    .page-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 1.5rem;
        color: #1F2937;
        margin: 0 0 5px 0;
    }
    
    .page-subtitle {
        font-family: 'Roboto', sans-serif;
        color: #6B7280;
        font-size: 0.85rem;
    }
    
    /* Filter Bar */
    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 24px;
    }
    
    .filter-group {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .filter-select {
        padding: 8px 12px;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        font-family: 'Roboto', sans-serif;
        font-size: 0.85rem;
        background: white;
        outline: none;
        cursor: pointer;
    }
    
    .filter-select:focus {
        border-color: #1D4ED8;
        box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1);
    }
    
    .btn-filter {
        background: #1D4ED8;
        color: white;
        padding: 8px 16px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    
    .btn-filter:hover {
        background: #1E3A8A;
        transform: translateY(-1px);
    }
    
    .action-group {
        display: flex;
        gap: 10px;
    }
    
    .btn-add {
        background: #10B981;
        color: white;
        padding: 8px 16px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    
    .btn-add:hover {
        background: #059669;
        transform: translateY(-1px);
        color: white;
    }
    
    .btn-generate {
        background: #F59E0B;
        color: white;
        padding: 8px 16px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    
    .btn-generate:hover {
        background: #D97706;
        transform: translateY(-1px);
    }
    
    /* Data Card */
    .data-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
    }
    
    .table-container {
        overflow-x: auto;
    }
    
    .table-modern {
        width: 100%;
        font-family: 'Roboto', sans-serif;
        border-collapse: collapse;
    }
    
    .table-modern thead th {
        background: #F9FAFB;
        padding: 14px 16px;
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #E5E7EB;
        text-align: left;
    }
    
    .table-modern tbody td {
        padding: 14px 16px;
        font-size: 0.85rem;
        color: #374151;
        border-bottom: 1px solid #F3F4F6;
        vertical-align: middle;
    }
    
    .table-modern tbody tr:hover td {
        background: #F9FAFB;
    }
    
    /* Employee Link */
    .employee-link {
        color: #1D4ED8;
        text-decoration: none;
        font-weight: 500;
    }
    
    .employee-link:hover {
        text-decoration: underline;
    }
    
    /* Status Badges */
    .badge-status {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .badge-draft {
        background: #F3F4F6;
        color: #6B7280;
    }
    
    .badge-generated {
        background: #EFF6FF;
        color: #1D4ED8;
    }
    
    .badge-approved {
        background: #D1FAE5;
        color: #065F46;
    }
    
    .badge-paid {
        background: #F3E8FF;
        color: #7E22CE;
    }
    
    /* Net Pay */
    .net-pay {
        font-weight: 700;
        color: #10B981;
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }
    
    .btn-action {
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 0.75rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    
    .btn-view {
        background: #EFF6FF;
        color: #1D4ED8;
    }
    
    .btn-view:hover {
        background: #DBEAFE;
    }
    
    .btn-edit {
        background: #FEF3C7;
        color: #D97706;
    }
    
    .btn-edit:hover {
        background: #FDE68A;
    }
    
    .btn-approve {
        background: #D1FAE5;
        color: #065F46;
    }
    
    .btn-approve:hover {
        background: #A7F3D0;
    }
    
    .btn-paid {
        background: #F3E8FF;
        color: #7E22CE;
    }
    
    .btn-paid:hover {
        background: #E9D5FF;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #9CA3AF;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 15px;
        display: block;
    }
    
    /* Pagination */
    .pagination-container {
        padding: 16px 20px;
        border-top: 1px solid #E5E7EB;
    }
    
    /* Modal */
    .modal-custom {
        border-radius: 20px;
        border: none;
        overflow: hidden;
    }
    
    .modal-header-custom {
        padding: 20px 24px;
        border-bottom: 1px solid #E5E7EB;
        background: #F9FAFB;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .modal-header-custom h5 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 1.1rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .modal-header-custom h5 i {
        color: #F59E0B;
    }
    
    .modal-body-custom {
        padding: 24px;
    }
    
    .modal-footer-custom {
        padding: 16px 24px;
        border-top: 1px solid #E5E7EB;
        background: #F9FAFB;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }
    
    .alert-warning-custom {
        background: #FEF3C7;
        padding: 12px 16px;
        border-radius: 12px;
        display: flex;
        gap: 10px;
        align-items: center;
        margin-top: 20px;
    }
    
    .alert-warning-custom i {
        color: #D97706;
    }
    
    .alert-warning-custom span {
        font-family: 'Roboto', sans-serif;
        font-size: 0.8rem;
        color: #92400E;
    }
    
    .btn-close-custom {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #6B7280;
    }
    
    .btn-close-custom:hover {
        color: #374151;
    }
    
    .btn-cancel {
        background: #F3F4F6;
        color: #374151;
        padding: 8px 20px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
    }
    
    .btn-cancel:hover {
        background: #E5E7EB;
    }
    
    @media (max-width: 768px) {
        .filter-bar {
            flex-direction: column;
            align-items: stretch;
        }
        
        .filter-group {
            justify-content: space-between;
        }
        
        .action-group {
            justify-content: flex-start;
        }
        
        .table-modern thead th,
        .table-modern tbody td {
            padding: 10px 12px;
        }
        
        .action-buttons {
            flex-wrap: wrap;
        }
    }
</style>

<div class="container-fluid">
    <div class="page-header">
        <div>
            <h1 class="page-title">Payroll Management</h1>
            <p class="page-subtitle">Manage employee salaries, bonuses, and payment status</p>
        </div>
    </div>
    
    <div class="filter-bar">
        <form method="GET" action="{{ route('payrolls.index') }}" class="filter-group" style="margin: 0;">
            <select name="month" class="filter-select">
                @foreach($months as $key => $monthName)
                <option value="{{ $key }}" {{ $month == $key ? 'selected' : '' }}>{{ $monthName }}</option>
                @endforeach
            </select>
            <select name="year" class="filter-select">
                @foreach($years as $yearOption)
                <option value="{{ $yearOption }}" {{ $year == $yearOption ? 'selected' : '' }}>{{ $yearOption }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-filter">
                <i class="fas fa-filter"></i> Filter
            </button>
        </form>
        
        @can('create', App\Models\Payroll::class)
        <div class="action-group">
            <a href="{{ route('payrolls.create') }}" class="btn-add">
                <i class="fas fa-plus"></i> Add Payroll
            </a>
            <button type="button" class="btn-generate" data-bs-toggle="modal" data-bs-target="#generateAllModal">
                <i class="fas fa-sync-alt"></i> Generate All
            </button>
        </div>
        @endcan
    </div>
    
    <div class="data-card">
        <div class="table-container">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Base Salary</th>
                        <th>Bonuses</th>
                        <th>Deductions</th>
                        <th>Net Pay</th>
                        <th>Status</th>
                        <th style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payrolls as $payroll)
                    <tr>
                        <td>
                            <a href="{{ route('employees.show', $payroll->employee_id) }}" class="employee-link">
                                {{ $payroll->employee->getFullName() }}
                            </a>
                        </td>
                        <td>{{ $payroll->employee->department->name ?? '—' }}</td>
                        <td>{{ number_format($payroll->base_salary, 2) }} DH</td>
                        <td>{{ number_format($payroll->bonuses, 2) }} DH</td>
                        <td>{{ number_format($payroll->deductions, 2) }} DH</td>
                        <td class="net-pay">{{ number_format($payroll->net_pay, 2) }} DH</td>
                        <td>
                            <span class="badge-status 
                                @if($payroll->status == 'draft') badge-draft
                                @elseif($payroll->status == 'generated') badge-generated
                                @elseif($payroll->status == 'approved') badge-approved
                                @else badge-paid @endif">
                                <i class="fas 
                                    @if($payroll->status == 'draft') fa-pen
                                    @elseif($payroll->status == 'generated') fa-clock
                                    @elseif($payroll->status == 'approved') fa-check-circle
                                    @else fa-check-double @endif"></i>
                                {{ ucfirst($payroll->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('payrolls.show', $payroll) }}" class="btn-action btn-view" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @can('update', $payroll)
                                <a href="{{ route('payrolls.edit', $payroll) }}" class="btn-action btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                @if($payroll->status == 'generated' && (auth()->user()->isAdmin() || auth()->user()->isManager()))
                                <form method="POST" action="{{ route('payrolls.approve', $payroll) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-action btn-approve" title="Approve">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                </form>
                                @endif
                                @if($payroll->status == 'approved' && auth()->user()->isAdmin())
                                <form method="POST" action="{{ route('payrolls.mark-paid', $payroll) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-action btn-paid" title="Mark as Paid">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="empty-state">
                            <i class="fas fa-file-invoice-dollar"></i>
                            No payroll records found for {{ $months[$month] }} {{ $year }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($payrolls->hasPages())
        <div class="pagination-container">
            {{ $payrolls->links() }}
        </div>
        @endif
    </div>
</div>

<div class="modal fade" id="generateAllModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header" style="padding: 20px 24px; border-bottom: 1px solid #E5E7EB; background: #F9FAFB;">
                <h5 class="modal-title" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                    <i class="fas fa-sync-alt" style="color: #F59E0B;"></i> Generate Payroll for All Employees
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('payrolls.generate-all') }}">
                @csrf
                <div class="modal-body" style="padding: 24px;">
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-family: 'Inter', sans-serif; font-size: 0.85rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Month</label>
                        <select name="month" class="form-select" style="width: 100%; padding: 10px; border: 1px solid #E5E7EB; border-radius: 10px;" required>
                            @foreach($months as $key => $monthName)
                            <option value="{{ $key }}" {{ $key == $month ? 'selected' : '' }}>{{ $monthName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-family: 'Inter', sans-serif; font-size: 0.85rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Year</label>
                        <select name="year" class="form-select" style="width: 100%; padding: 10px; border: 1px solid #E5E7EB; border-radius: 10px;" required>
                            @foreach($years as $yearOption)
                            <option value="{{ $yearOption }}" {{ $yearOption == $year ? 'selected' : '' }}>{{ $yearOption }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="alert alert-warning" style="background: #FEF3C7; padding: 12px 16px; border-radius: 12px; display: flex; gap: 10px; align-items: center;">
                        <i class="fas fa-exclamation-triangle" style="color: #D97706;"></i>
                        <span style="font-family: 'Roboto', sans-serif; font-size: 0.8rem; color: #92400E;">
                            This will generate payroll for all employees with active contracts. Existing payroll records will be skipped.
                        </span>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 16px 24px; border-top: 1px solid #E5E7EB; background: #F9FAFB;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background: #F3F4F6; color: #374151; padding: 8px 20px; border-radius: 10px; border: none;">Cancel</button>
                    <button type="submit" class="btn btn-warning" style="background: #F59E0B; color: white; padding: 8px 20px; border-radius: 10px; border: none;">
                        <i class="fas fa-sync-alt"></i> Generate All
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modalElement = document.getElementById('generateAllModal');
        if (modalElement) {
            var modal = bootstrap.Modal.getOrCreateInstance(modalElement);
        }
    });
</script>
@endpush