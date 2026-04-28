@extends('layouts.app')

@section('title', 'Contract Details')

@section('content')
<style>
    .details-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
        max-width: 900px;
        margin: 0 auto;
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
        font-size: 1rem;
        color: #1F2937;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid #E5E7EB;
    }
    
    .info-row {
        display: flex;
        margin-bottom: 12px;
    }
    
    .info-label {
        width: 130px;
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
    
    .info-value strong {
        font-weight: 600;
        color: #1F2937;
    }
    
    .badge-active {
        display: inline-block;
        padding: 4px 12px;
        background: #D1FAE5;
        color: #065F46;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-expired {
        display: inline-block;
        padding: 4px 12px;
        background: #FEE2E2;
        color: #991B1B;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-type {
        display: inline-block;
        padding: 4px 12px;
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
    
    .btn-download {
        background: #10B981;
        color: white;
        padding: 8px 16px;
        border-radius: 10px;
        text-decoration: none;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    
    .btn-download:hover {
        background: #059669;
    }
    
    .action-buttons {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #E5E7EB;
    }
    
    .btn-edit {
        background: #FEF3C7;
        color: #D97706;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    
    .btn-edit:hover {
        background: #FDE68A;
    }
    
    .btn-delete {
        background: #FEE2E2;
        color: #DC2626;
        padding: 10px 20px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    
    .btn-delete:hover {
        background: #FECACA;
    }
    
    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        
        .card-header-custom {
            padding: 16px 20px;
        }
        
        .card-body-custom {
            padding: 20px;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-edit, .btn-delete {
            justify-content: center;
        }
    }
</style>

<div class="container-fluid">
    <div class="details-card">
        <div class="card-header-custom">
            <h3>
                <i class="fas fa-file-contract"></i> Contract Details
            </h3>
            <a href="{{ route('contracts.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
        <div class="card-body-custom">
            <div class="info-grid">
                <div class="info-section">
                    <h4><i class="fas fa-user"></i> Employee Information</h4>
                    <div class="info-row">
                        <div class="info-label">Full Name</div>
                        <div class="info-value"><strong>{{ $contract->employee->getFullName() }}</strong></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $contract->employee->email }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Position</div>
                        <div class="info-value">{{ $contract->position }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Department</div>
                        <div class="info-value">{{ $contract->employee->department->name ?? 'Not assigned' }}</div>
                    </div>
                </div>

                <div class="info-section">
                    <h4><i class="fas fa-info-circle"></i> Contract Information</h4>
                    <div class="info-row">
                        <div class="info-label">Contract Type</div>
                        <div class="info-value">
                            <span class="badge-type 
                                @if($contract->type == 'permanent') badge-permanent
                                @elseif($contract->type == 'fixed-term') badge-fixed
                                @elseif($contract->type == 'internship') badge-internship
                                @else badge-freelance @endif">
                                {{ ucfirst($contract->type) }}
                            </span>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            @if($contract->isActive())
                                <span class="badge-active"><i class="fas fa-check-circle"></i> Active</span>
                            @else
                                <span class="badge-expired"><i class="fas fa-times-circle"></i> Expired</span>
                            @endif
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Start Date</div>
                        <div class="info-value">{{ $contract->start_date->format('d/m/Y') }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">End Date</div>
                        <div class="info-value">{{ $contract->end_date ? $contract->end_date->format('d/m/Y') : 'No end date (Permanent)' }}</div>
                    </div>
                </div>
            </div>
            
            <div class="info-section" style="margin-bottom: 20px;">
                <h4><i class="fas fa-money-bill-wave"></i> Salary Information</h4>
                <div class="info-row">
                    <div class="info-label">Base Salary</div>
                    <div class="info-value">{{ number_format($contract->base_salary, 2) }} DH</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Bonus</div>
                    <div class="info-value">{{ number_format($contract->bonus, 2) }} DH</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Total Package</div>
                    <div class="info-value"><strong>{{ number_format($contract->getTotalSalary(), 2) }} DH</strong></div>
                </div>
            </div>
            
            @if($contract->document_path)
            <div class="info-section" style="margin-bottom: 20px;">
                <h4><i class="fas fa-file-pdf"></i> Contract Document</h4>
                <div class="info-row">
                    <div class="info-label">Document</div>
                    <div class="info-value">
                        <a href="{{ asset('storage/' . $contract->document_path) }}" target="_blank" class="btn-download">
                            <i class="fas fa-download"></i> Download Contract
                        </a>
                    </div>
                </div>
            </div>
            @endif
            
            <div class="action-buttons">
                @can('update', $contract)
                <a href="{{ route('contracts.edit', $contract) }}" class="btn-edit">
                    <i class="fas fa-edit"></i> Edit Contract
                </a>
                @endcan
                @can('delete', $contract)
                <form method="POST" action="{{ route('contracts.destroy', $contract) }}" class="d-inline" 
                      onsubmit="return confirm('Are you sure? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">
                        <i class="fas fa-trash"></i> Delete Contract
                    </button>
                </form>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection