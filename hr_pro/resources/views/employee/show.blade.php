@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
<style>
    .details-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
        margin-bottom: 24px;
    }
    
    .card-header-custom {
        padding: 20px 24px;
        border-bottom: 1px solid #E5E7EB;
        background: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .card-header-custom h3 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 1.25rem;
        color: #1F2937;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .card-header-custom h3 i {
        color: #1D4ED8;
    }
    
    .btn-back {
        background: #F3F4F6;
        color: #374151;
        padding: 8px 16px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-back:hover {
        background: #E5E7EB;
        color: #1F2937;
    }
    
    .card-body-custom {
        padding: 24px;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 24px;
    }
    
    .info-section {
        background: #F9FAFB;
        border-radius: 16px;
        padding: 20px;
    }
    
    .info-section h4 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        color: #1F2937;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid #E5E7EB;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .info-section h4 i {
        color: #1D4ED8;
    }
    
    .info-row {
        display: flex;
        margin-bottom: 12px;
    }
    
    .info-label {
        width: 140px;
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        font-weight: 500;
        color: #6B7280;
    }
    
    .info-value {
        flex: 1;
        font-family: 'Roboto', sans-serif;
        font-size: 0.85rem;
        color: #374151;
    }
    
    .badge-status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-active {
        background: #D1FAE5;
        color: #065F46;
    }
    
    .badge-inactive {
        background: #FEE2E2;
        color: #991B1B;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        text-align: center;
        border: 1px solid #E5E7EB;
    }
    
    .stat-card.primary {
        background: linear-gradient(135deg, #1D4ED8 0%, #1E3A8A 100%);
        color: white;
    }
    
    .stat-card.success {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        color: white;
    }
    
    .stat-card.warning {
        background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        color: white;
    }
    
    .stat-title {
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        font-weight: 500;
        margin-bottom: 8px;
        opacity: 0.9;
    }
    
    .stat-value {
        font-family: 'Inter', sans-serif;
        font-size: 1.8rem;
        font-weight: 700;
    }
    
    .contract-table {
        width: 100%;
        font-family: 'Roboto', sans-serif;
        border-collapse: collapse;
    }
    
    .contract-table th {
        background: #F3F4F6;
        padding: 10px 12px;
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        color: #6B7280;
        text-align: left;
        border-bottom: 1px solid #E5E7EB;
    }
    
    .contract-table td {
        padding: 10px 12px;
        border-bottom: 1px solid #F3F4F6;
        font-size: 0.85rem;
    }
    
    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }
        
        .card-header-custom {
            padding: 16px 20px;
        }
        
        .card-body-custom {
            padding: 20px;
        }
        
        .info-row {
            flex-direction: column;
        }
        
        .info-label {
            width: 100%;
            margin-bottom: 4px;
        }
    }
</style>

<div class="container-fluid">
    <div class="details-card">
        <div class="card-header-custom">
            <h3>
                <i class="fas fa-user-circle"></i> Employee Details: {{ $employee->getFullName() }}
            </h3>
            <a href="{{ route('employees.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
        <div class="card-body-custom">
            <div class="info-grid">
                <div class="info-section">
                    <h4><i class="fas fa-user"></i> Personal Information</h4>
                    <div class="info-row">
                        <div class="info-label">First Name</div>
                        <div class="info-value"><strong>{{ $employee->first_name }}</strong></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Last Name</div>
                        <div class="info-value"><strong>{{ $employee->last_name }}</strong></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $employee->email }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Phone</div>
                        <div class="info-value">{{ $employee->phone ?? '—' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Birth Date</div>
                        <div class="info-value">{{ $employee->birth_date ? $employee->birth_date->format('d/m/Y') : '—' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Address</div>
                        <div class="info-value">{{ $employee->address ?? '—' }}</div>
                    </div>
                </div>
                
                <div class="info-section">
                    <h4><i class="fas fa-briefcase"></i> Employment Information</h4>
                    <div class="info-row">
                        <div class="info-label">Department</div>
                        <div class="info-value">{{ $employee->department->name ?? '—' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Role</div>
                        <div class="info-value">{{ ucfirst($employee->role->name ?? 'N/A') }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            @if($employee->is_active)
                                <span class="badge-status badge-active"><i class="fas fa-check-circle"></i> Active</span>
                            @else
                                <span class="badge-status badge-inactive"><i class="fas fa-times-circle"></i> Inactive</span>
                            @endif
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">ID Number</div>
                        <div class="info-value">{{ $employee->id_number ?? '—' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Social Security Number</div>
                        <div class="info-value">{{ $employee->social_security_number ?? '—' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Leave Balance</div>
                        <div class="info-value"><strong>{{ $currentBalance ? $currentBalance->remaining_days : 0 }} days</strong> remaining</div>
                    </div>
                </div>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card primary">
                    <div class="stat-title">Total Leaves</div>
                    <div class="stat-value">{{ $totalLeaves }}</div>
                </div>
                <div class="stat-card success">
                    <div class="stat-title">Approved Leaves</div>
                    <div class="stat-value">{{ $approvedLeaves }}</div>
                </div>
                <div class="stat-card warning">
                    <div class="stat-title">Pending Leaves</div>
                    <div class="stat-value">{{ $pendingLeaves }}</div>
                </div>
            </div>
            
            @if($activeContract)
            <div class="info-section" style="margin-top: 0;">
                <h4><i class="fas fa-file-signature"></i> Active Contract</h4>
                <table class="contract-table">
                    <thead>
                        <tr>
                            <th>Position</th>
                            <th>Type</th>
                            <th>Base Salary</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>{{ $activeContract->position }}</strong></td>
                            <td>{{ ucfirst($activeContract->type) }}</td>
                            <td>{{ number_format($activeContract->base_salary, 2) }} DH</a>
                            <td>{{ $activeContract->start_date->format('d/m/Y') }}</a>
                            <td>{{ $activeContract->end_date ? $activeContract->end_date->format('d/m/Y') : 'Ongoing' }}</a>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection