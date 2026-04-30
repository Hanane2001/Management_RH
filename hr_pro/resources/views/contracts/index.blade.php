@extends('layouts.app')

@section('title', 'Contracts')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .page-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 1.5rem;
        color: #1F2937;
        margin: 0;
    }
    
    .btn-add {
        background: #1D4ED8;
        color: white;
        padding: 10px 20px;
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
        background: #1E3A8A;
        color: white;
    }
    
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
    }
    
    .table-modern tbody tr:hover td {
        background: #F9FAFB;
    }
    
    .badge-active {
        display: inline-block;
        padding: 4px 10px;
        background: #D1FAE5;
        color: #065F46;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .badge-expired {
        display: inline-block;
        padding: 4px 10px;
        background: #FEE2E2;
        color: #991B1B;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .badge-type {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .badge-permanent {
        background: #EFF6FF;
        color: #1D4ED8;
    }
    
    .badge-fixed {
        background: #FEF3C7;
        color: #D97706;
    }
    
    .badge-internship {
        background: #F3E8FF;
        color: #7E22CE;
    }
    
    .badge-freelance {
        background: #FCE7F3;
        color: #BE185D;
    }
    
    .action-buttons {
        display: flex;
        gap: 6px;
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
    
    .btn-delete {
        background: #FEE2E2;
        color: #DC2626;
    }
    
    .btn-delete:hover {
        background: #FECACA;
    }
    
    .employee-link {
        color: #1D4ED8;
        text-decoration: none;
        font-weight: 500;
    }
    
    .employee-link:hover {
        text-decoration: underline;
    }
    
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
    
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .table-modern thead th,
        .table-modern tbody td {
            padding: 10px 12px;
        }
    }
</style>

<div class="container-fluid">
    <div class="page-header">
        <h1 class="page-title">Contracts</h1>
        @can('create', App\Models\Contract::class)
        <a href="{{ route('contracts.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> Add Contract
        </a>
        @endcan
    </div>
    
    <div class="data-card">
        <div class="table-container">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Position</th>
                        <th>Type</th>
                        <th>Base Salary</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contracts as $contract)
                    <tr>
                        <td>
                            <a href="{{ route('employees.show', $contract->employee_id) }}" class="employee-link">
                                {{ $contract->employee->getFullName() }}
                            </a>
                        <td style="font-weight: 500;">{{ $contract->position }}</a>
                        <td>
                            <span class="badge-type 
                                @if($contract->type == 'permanent') badge-permanent
                                @elseif($contract->type == 'fixed-term') badge-fixed
                                @elseif($contract->type == 'internship') badge-internship
                                @else badge-freelance @endif">
                                {{ ucfirst($contract->type) }}
                            </span>
                        </td>
                        <td>{{ number_format($contract->base_salary, 2) }} DH</td>
                        <td>{{ $contract->start_date->format('d/m/Y') }}</td>
                        <td>{{ $contract->end_date ? $contract->end_date->format('d/m/Y') : '—' }}</td>
                        <td>
                            @if($contract->isActive())
                                <span class="badge-active"><i class="fas fa-check-circle"></i> Active</span>
                            @else
                                <span class="badge-expired"><i class="fas fa-times-circle"></i> Expired</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('contracts.show', $contract) }}" class="btn-action btn-view" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @can('update', $contract)
                                <a href="{{ route('contracts.edit', $contract) }}" class="btn-action btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                @can('delete', $contract)
                                <form method="POST" action="{{ route('contracts.destroy', $contract) }}" class="d-inline" 
                                      onsubmit="return confirm('Are you sure? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="empty-state">
                            <i class="fas fa-file-contract"></i>
                            No contracts found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection