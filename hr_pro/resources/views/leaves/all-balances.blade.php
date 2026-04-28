@extends('layouts.app')

@section('title', 'All Leave Balances')

@section('content')
<style>
    .page-header {
        margin-bottom: 24px;
    }
    
    .page-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 1.5rem;
        color: #1F2937;
        margin: 0 0 5px;
    }
    
    .page-subtitle {
        font-family: 'Roboto', sans-serif;
        color: #6B7280;
        font-size: 0.85rem;
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
    
    .employee-link {
        color: #1D4ED8;
        text-decoration: none;
        font-weight: 500;
    }
    
    .employee-link:hover {
        text-decoration: underline;
    }
    
    .badge-exhausted {
        background: #FEE2E2;
        color: #991B1B;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
        display: inline-block;
    }
    
    .badge-critical {
        background: #FEF3C7;
        color: #D97706;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
        display: inline-block;
    }
    
    .badge-low {
        background: #DBEAFE;
        color: #1E40AF;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
        display: inline-block;
    }
    
    .badge-good {
        background: #D1FAE5;
        color: #065F46;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
        display: inline-block;
    }
    
    .progress-small {
        height: 8px;
        background: #E5E7EB;
        border-radius: 10px;
        overflow: hidden;
        width: 120px;
    }
    
    .progress-bar-small {
        height: 100%;
        border-radius: 10px;
    }
    
    .text-success {
        color: #10B981;
        font-weight: 600;
    }
    
    .text-warning {
        color: #D97706;
        font-weight: 600;
    }
    
    .text-danger {
        color: #DC2626;
        font-weight: 600;
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
    
    .pagination-container {
        padding: 20px;
        border-top: 1px solid #E5E7EB;
    }
    
    @media (max-width: 768px) {
        .table-modern thead th,
        .table-modern tbody td {
            padding: 10px 12px;
        }
        
        .progress-small {
            width: 80px;
        }
    }
</style>

<div class="container-fluid">
    <div class="page-header">
        <h1 class="page-title">Leave Balances</h1>
        <p class="page-subtitle">Employee leave balances for {{ date('Y') }}</p>
    </div>
    
    <div class="data-card">
        <div class="table-container">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Total Days</th>
                        <th>Used Days</th>
                        <th>Remaining</th>
                        <th>Usage</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($balances as $balance)
                    <tr>
                        <td>
                            <a href="{{ route('employees.show', $balance->employee_id) }}" class="employee-link">
                                {{ $balance->employee->getFullName() }}
                            </a>
                        </a>
                        <td>{{ $balance->employee->department->name ?? 'N/A' }}</a>
                        <td>{{ $balance->total_days }} days</a>
                        <td>{{ $balance->used_days }} days</a>
                        <td>
                            @php
                                $remainingClass = 'text-success';
                                if($balance->remaining_days == 0) $remainingClass = 'text-danger';
                                elseif($balance->remaining_days < 5) $remainingClass = 'text-warning';
                            @endphp
                            <span class="{{ $remainingClass }}"><strong>{{ $balance->remaining_days }}</strong> days</span>
                        </a>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div class="progress-small">
                                    @php
                                        $usagePercent = $balance->getUsedPercentage();
                                        $usageColor = $usagePercent > 80 ? '#DC2626' : ($usagePercent > 50 ? '#D97706' : '#10B981');
                                    @endphp
                                    <div class="progress-bar-small" style="width: {{ $usagePercent }}%; background: {{ $usageColor }};"></div>
                                </div>
                                <span style="font-size: 0.7rem;">{{ number_format($usagePercent, 1) }}%</span>
                            </div>
                        </a>
                        <td>
                            @if($balance->remaining_days == 0)
                                <span class="badge-exhausted"><i class="fas fa-times-circle"></i> Exhausted</span>
                            @elseif($balance->remaining_days < 5)
                                <span class="badge-critical"><i class="fas fa-exclamation-triangle"></i> Critical</span>
                            @elseif($balance->remaining_days < 10)
                                <span class="badge-low"><i class="fas fa-info-circle"></i> Low</span>
                            @else
                                <span class="badge-good"><i class="fas fa-check-circle"></i> Good</span>
                            @endif
                        </a>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            <i class="fas fa-chart-line"></i>
                            No leave balances found
                        </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($balances->hasPages())
            <div class="pagination-container">
                {{ $balances->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection