@extends('layouts.app')

@section('title', 'Payroll Details')

@section('content')
<style>
    .details-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
        max-width: 1000px;
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
    
    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 28px;
    }
    
    .info-section {
        background: #F9FAFB;
        border-radius: 16px;
        padding: 20px;
    }
    
    .info-section h4 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.95rem;
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
        font-size: 1rem;
    }
    
    .info-row {
        display: flex;
        margin-bottom: 12px;
    }
    
    .info-label {
        width: 120px;
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
    
    /* Status Badges */
    .badge-status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
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
    
    /* Salary Table */
    .salary-section {
        margin-top: 8px;
    }
    
    .salary-section h4 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.95rem;
        color: #1F2937;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .salary-section h4 i {
        color: #10B981;
    }
    
    .salary-table {
        width: 100%;
        font-family: 'Roboto', sans-serif;
        border-collapse: collapse;
        background: #F9FAFB;
        border-radius: 16px;
        overflow: hidden;
    }
    
    .salary-table tr td {
        padding: 14px 20px;
        border-bottom: 1px solid #E5E7EB;
    }
    
    .salary-table tr td:first-child {
        font-weight: 500;
        color: #6B7280;
        width: 35%;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
    }
    
    .salary-table tr td:last-child {
        color: #374151;
        font-weight: 500;
        font-family: 'Inter', sans-serif;
    }
    
    .salary-table tr:last-child td {
        border-bottom: none;
    }
    
    .salary-table .total-row td {
        background: #F0FDF4;
        font-weight: 700;
        border-top: 1px solid #D1FAE5;
        border-bottom: none;
    }
    
    .salary-table .total-row td:first-child {
        font-weight: 700;
        color: #065F46;
    }
    
    .salary-table .total-row td:last-child {
        font-weight: 700;
        color: #10B981;
    }
    
    .salary-table .net-row td {
        background: #ECFDF5;
    }
    
    .net-pay-value {
        font-size: 1rem;
        font-weight: 700;
        color: #10B981;
    }
    
    .help-text {
        font-size: 0.7rem;
        color: #9CA3AF;
        margin-left: 8px;
        font-weight: normal;
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid #E5E7EB;
        flex-wrap: wrap;
    }
    
    .btn-warning {
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
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-warning:hover {
        background: #FDE68A;
        transform: translateY(-1px);
    }
    
    .btn-success {
        background: #D1FAE5;
        color: #065F46;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-success:hover {
        background: #A7F3D0;
        transform: translateY(-1px);
    }
    
    .btn-primary {
        background: #EFF6FF;
        color: #1D4ED8;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-primary:hover {
        background: #DBEAFE;
        transform: translateY(-1px);
    }
    
    .btn-danger {
        background: #FEE2E2;
        color: #DC2626;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-danger:hover {
        background: #FECACA;
        transform: translateY(-1px);
    }
    
    .btn-secondary {
        background: #F3F4F6;
        color: #374151;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-secondary:hover {
        background: #E5E7EB;
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
        
        .info-row {
            flex-direction: column;
        }
        
        .info-label {
            width: 100%;
            margin-bottom: 4px;
        }
        
        .salary-table tr td {
            padding: 10px 16px;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-warning, .btn-success, .btn-primary, .btn-danger, .btn-secondary {
            justify-content: center;
        }
    }
</style>

<div class="container-fluid">
    <div class="details-card">
        <div class="card-header-custom">
            <h3>
                <i class="fas fa-file-invoice-dollar"></i> 
                Payroll Details - {{ $payroll->getMonthName() }} {{ $payroll->year }}
            </h3>
            <a href="{{ route('payrolls.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
        
        <div class="card-body-custom">
            <!-- Employee & Payroll Information -->
            <div class="info-grid">
                <!-- Employee Information -->
                <div class="info-section">
                    <h4>
                        <i class="fas fa-user"></i> Employee Information
                    </h4>
                    <div class="info-row">
                        <div class="info-label">Full Name</div>
                        <div class="info-value"><strong>{{ $payroll->employee->getFullName() }}</strong></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Department</div>
                        <div class="info-value">{{ $payroll->employee->department->name ?? '—' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Position</div>
                        <div class="info-value">{{ $payroll->employee->contracts->first()->position ?? '—' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $payroll->employee->email }}</div>
                    </div>
                </div>
                
                <!-- Payroll Information -->
                <div class="info-section">
                    <h4>
                        <i class="fas fa-info-circle"></i> Payroll Information
                    </h4>
                    <div class="info-row">
                        <div class="info-label">Period</div>
                        <div class="info-value">{{ $payroll->getMonthName() }} {{ $payroll->year }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Status</div>
                        <div class="info-value">
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
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Created Date</div>
                        <div class="info-value">{{ $payroll->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Last Updated</div>
                        <div class="info-value">{{ $payroll->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Salary Breakdown -->
            <div class="salary-section">
                <h4>
                    <i class="fas fa-chart-line"></i> Salary Breakdown
                </h4>
                
                <table class="salary-table">
                    <tr>
                        <td>Base Salary</td>
                        <td>{{ number_format($payroll->base_salary, 2) }} DH</td>
                    </tr>
                    <tr>
                        <td>Overtime Hours <span class="help-text">({{ $payroll->overtime_hours }} hours @ 1.5x rate)</span></td>
                        <td>
                            @php
                                $dailyRate = $payroll->base_salary / 22;
                                $hourlyRate = $dailyRate / 8;
                                $overtimePay = $payroll->overtime_hours * $hourlyRate * 1.5;
                            @endphp
                            {{ number_format($overtimePay, 2) }} DH
                        </td>
                    </tr>
                    <tr>
                        <td>Bonuses</td>
                        <td>{{ number_format($payroll->bonuses, 2) }} DH</td>
                    </tr>
                    <tr>
                        <td>Allowances</td>
                        <td>{{ number_format($payroll->allowances, 2) }} DH</td>
                    </tr>
                    <tr style="background: #F9FAFB;">
                        <td><strong>Gross Salary</strong></td>
                        <td><strong>{{ number_format($payroll->getTotalSalary(), 2) }} DH</strong></td>
                    </tr>
                    <tr>
                        <td>Deductions</td>
                        <td style="color: #EF4444;">- {{ number_format($payroll->deductions, 2) }} DH</td>
                    </tr>
                    <tr class="total-row">
                        <td><strong>NET PAY</strong></td>
                        <td class="net-pay-value"><strong>{{ number_format($payroll->net_pay, 2) }} DH</strong></td>
                    </tr>
                </table>
            </div>
            
            <!-- Action Buttons -->
            <div class="action-buttons">
                @can('update', $payroll)
                <a href="{{ route('payrolls.edit', $payroll) }}" class="btn-warning">
                    <i class="fas fa-edit"></i> Edit Payroll
                </a>
                @endcan
                
                @if($payroll->status == 'generated' && (auth()->user()->isAdmin() || auth()->user()->isManager()))
                <form method="POST" action="{{ route('payrolls.approve', $payroll) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn-success">
                        <i class="fas fa-check-circle"></i> Approve Payroll
                    </button>
                </form>
                @endif
                
                @if($payroll->status == 'approved' && auth()->user()->isAdmin())
                <form method="POST" action="{{ route('payrolls.mark-paid', $payroll) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-money-bill-wave"></i> Mark as Paid
                    </button>
                </form>
                @endif
                
                @can('delete', $payroll)
                <form method="POST" action="{{ route('payrolls.destroy', $payroll) }}" class="d-inline" 
                      onsubmit="return confirm('Are you sure? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger">
                        <i class="fas fa-trash"></i> Delete Payroll
                    </button>
                </form>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection