@extends('layouts.app')

@section('title', 'Departments')

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
    
    .badge-manager {
        display: inline-block;
        padding: 4px 10px;
        background: #EFF6FF;
        color: #1D4ED8;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .badge-unassigned {
        display: inline-block;
        padding: 4px 10px;
        background: #F3F4F6;
        color: #6B7280;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
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
        
        .action-buttons {
            flex-wrap: wrap;
        }
    }
</style>

<div class="container-fluid">
    <div class="page-header">
        <h1 class="page-title">Departments</h1>
        @can('create', App\Models\Department::class)
        <a href="{{ route('departments.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> Add Department
        </a>
        @endcan
    </div>
    
    <div class="data-card">
        <div class="table-container">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Manager</th>
                        <th>Employees</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $department)
                    <tr>
                        <td style="font-weight: 500;">{{ $department->name }}</td>
                        <td>
                            @if($department->manager)
                                <span class="badge-manager">
                                    <i class="fas fa-user-check"></i> {{ $department->manager->getFullName() }}
                                </span>
                            @else
                                <span class="badge-unassigned">
                                    <i class="fas fa-user-slash"></i> Not Assigned
                                </span>
                            @endif
                        </td>
                        <td>{{ $department->getEmployeeCount() }} employees</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('departments.show', $department->id) }}" class="btn-action btn-view" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @can('update', $department)
                                <a href="{{ route('departments.edit', $department->id) }}" class="btn-action btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                @can('delete', $department)
                                <form method="POST" action="{{ route('departments.destroy', $department->id) }}" class="d-inline" 
                                      onsubmit="return confirm('Are you sure? This will affect all employees in this department.')">
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
                        <td colspan="4" class="empty-state">
                            <i class="fas fa-building"></i>
                            No departments found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection