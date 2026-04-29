@extends('layouts.app')

@section('title', 'Department Details')

@section('content')
<style>
    .details-grid {
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 24px;
    }
    
    .info-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
    }
    
    .card-header-custom {
        padding: 16px 20px;
        border-bottom: 1px solid #E5E7EB;
        background: #F9FAFB;
    }
    
    .card-header-custom h4 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 1rem;
        color: #1F2937;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .card-header-custom h4 i {
        color: #1D4ED8;
    }
    
    .card-body-custom {
        padding: 20px;
    }
    
    .info-table {
        width: 100%;
        font-family: 'Roboto', sans-serif;
    }
    
    .info-table tr td {
        padding: 10px 0;
        border-bottom: 1px solid #F3F4F6;
    }
    
    .info-table tr td:first-child {
        width: 40%;
        font-weight: 500;
        color: #6B7280;
        font-size: 0.8rem;
    }
    
    .info-table tr td:last-child {
        color: #374151;
        font-size: 0.85rem;
    }
    
    .info-table tr:last-child td {
        border-bottom: none;
    }
    
    .btn-group-department {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    
    .btn-department {
        flex: 1;
        padding: 10px;
        border-radius: 10px;
        text-align: center;
        text-decoration: none;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .btn-secondary {
        background: #F3F4F6;
        color: #374151;
    }
    
    .btn-secondary:hover {
        background: #E5E7EB;
    }
    
    .btn-warning {
        background: #FEF3C7;
        color: #D97706;
    }
    
    .btn-warning:hover {
        background: #FDE68A;
    }
    
    .employees-table {
        width: 100%;
        font-family: 'Roboto', sans-serif;
        border-collapse: collapse;
    }
    
    .employees-table thead th {
        background: #F9FAFB;
        padding: 12px 16px;
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #E5E7EB;
        text-align: left;
    }
    
    .employees-table tbody td {
        padding: 12px 16px;
        font-size: 0.85rem;
        color: #374151;
        border-bottom: 1px solid #F3F4F6;
    }
    
    .employees-table tbody tr:hover td {
        background: #F9FAFB;
    }
    
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #9CA3AF;
    }
    
    .empty-state i {
        font-size: 2rem;
        margin-bottom: 10px;
        display: block;
    }
    
    .badge-position {
        display: inline-block;
        padding: 4px 10px;
        background: #EFF6FF;
        color: #1D4ED8;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    @media (max-width: 768px) {
        .details-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }
</style>

<div class="container-fluid">
    <div class="details-grid">
        <div>
            <div class="info-card">
                <div class="card-header-custom">
                    <h4><i class="fas fa-building"></i> Department Information</h4>
                </div>
                <div class="card-body-custom">
                    <table class="info-table">
                        <tr>
                            <td>Department Name</td>
                            <td><strong>{{ $department->name }}</strong></td>
                        </tr>
                        <tr>
                            <td>Manager</td>
                            <td>
                                @if($department->manager)
                                    <span style="color: #10B981;">
                                        <i class="fas fa-user-check"></i> {{ $department->manager->getFullName() }}
                                    </span>
                                @else
                                    <span style="color: #9CA3AF;">
                                        <i class="fas fa-user-slash"></i> Not Assigned
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Employees Count</td>
                            <td>{{ $department->getEmployeeCount() }} employees</td>
                        </tr>
                        <tr>
                            <td>Created At</td>
                            <td>{{ $department->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td>Last Updated</td>
                            <td>{{ $department->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>{{ $department->description ?? 'No description provided' }}</td>
                        </tr>
                    </table>
                    
                    <div class="btn-group-department">
                        <a href="{{ route('departments.index') }}" class="btn-department btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        @can('update', $department)
                        <a href="{{ route('departments.edit', $department->id) }}" class="btn-department btn-warning">
                            <i class="fas fa-edit"></i> Edit Department
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        
        <div>
            <div class="info-card">
                <div class="card-header-custom">
                    <h4><i class="fas fa-users"></i> Employees in {{ $department->name }}</h4>
                </div>
                <div class="card-body-custom" style="padding: 0;">
                    <div style="overflow-x: auto;">
                        <table class="employees-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Position</th>
                                    <th style="width: 50px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($department->employees as $employee)
                                <tr>
                                    <td>{{ $employee->getFullName() }}</td>
                                    <td>{{ $employee->email }}</a></td>
                                    <td>
                                        <span class="badge-position">
                                            {{ $employee->contracts->first()->position ?? 'No position' }}
                                        </span>
                                    </a></td>
                                    <td>
                                        @can('viewAnyE', App\Models\User::class)
                                        <a href="{{ route('employees.show', $employee->id) }}" class="btn-action btn-view" style="padding: 4px 8px;" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @endcan
                                    </a>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="empty-state">
                                        <i class="fas fa-user-friends"></i>
                                        No employees in this department
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection