@extends('layouts.app')

@section('title', 'My Leave Balance')

@section('content')
<style>
    .balance-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
        max-width: 800px;
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
    
    .current-balance {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .balance-number {
        font-family: 'Inter', sans-serif;
        font-weight: 800;
        font-size: 3.5rem;
        color: #1D4ED8;
        margin: 10px 0;
    }
    
    .balance-label {
        font-family: 'Roboto', sans-serif;
        color: #6B7280;
        font-size: 0.9rem;
    }
    
    .progress-container {
        max-width: 400px;
        margin: 20px auto;
    }
    
    .progress-custom {
        display: flex;
        height: 30px;
        border-radius: 30px;
        overflow: hidden;
        background: #E5E7EB;
    }
    
    .progress-used {
        background: #EF4444;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .progress-remaining {
        background: #10B981;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .balance-stats {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-top: 15px;
    }
    
    .stat-item {
        text-align: center;
    }
    
    .stat-value {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 1.3rem;
        color: #1F2937;
    }
    
    .stat-label {
        font-family: 'Roboto', sans-serif;
        font-size: 0.75rem;
        color: #6B7280;
    }
    
    .section-title {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 1rem;
        color: #1F2937;
        margin: 20px 0 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #E5E7EB;
    }
    
    .table-modern {
        width: 100%;
        font-family: 'Roboto', sans-serif;
        border-collapse: collapse;
    }
    
    .table-modern thead th {
        background: #F9FAFB;
        padding: 12px 16px;
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #E5E7EB;
    }
    
    .table-modern tbody td {
        padding: 12px 16px;
        font-size: 0.85rem;
        color: #374151;
        border-bottom: 1px solid #F3F4F6;
    }
    
    .progress-small {
        height: 8px;
        background: #E5E7EB;
        border-radius: 10px;
        overflow: hidden;
        width: 100px;
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
    
    @media (max-width: 768px) {
        .card-header-custom {
            padding: 16px 20px;
        }
        
        .card-body-custom {
            padding: 20px;
        }
        
        .balance-number {
            font-size: 2.5rem;
        }
        
        .balance-stats {
            flex-direction: column;
            gap: 10px;
        }
        
        .table-modern thead th,
        .table-modern tbody td {
            padding: 8px 10px;
        }
    }
</style>

<div class="container-fluid">
    <div class="balance-card">
        <div class="card-header-custom">
            <h3>
                <i class="fas fa-chart-line"></i> My Leave Balance
            </h3>
            <a href="{{ route('leaves.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="card-body-custom">
            @if($currentBalance)
            <div class="current-balance">
                <div class="balance-number">{{ $currentBalance->remaining_days }}</div>
                <div class="balance-label">Days Remaining in {{ date('Y') }}</div>
                
                <div class="progress-container">
                    <div class="progress-custom">
                        @php
                            $usedPercent = ($currentBalance->used_days / $currentBalance->total_days) * 100;
                            $remainingPercent = ($currentBalance->remaining_days / $currentBalance->total_days) * 100;
                        @endphp
                        <div class="progress-used" style="width: {{ $usedPercent }}%">
                            @if($usedPercent > 15) Used: {{ $currentBalance->used_days }} @endif
                        </div>
                        <div class="progress-remaining" style="width: {{ $remainingPercent }}%">
                            @if($remainingPercent > 15) Remaining: {{ $currentBalance->remaining_days }} @endif
                        </div>
                    </div>
                </div>
                
                <div class="balance-stats">
                    <div class="stat-item">
                        <div class="stat-value">{{ $currentBalance->total_days }}</div>
                        <div class="stat-label">Total Days</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $currentBalance->used_days }}</div>
                        <div class="stat-label">Used Days</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ number_format($currentBalance->getUsedPercentage(), 1) }}%</div>
                        <div class="stat-label">Usage Rate</div>
                    </div>
                </div>
            </div>
            @else
            <div class="alert-info" style="background: #EFF6FF; padding: 20px; border-radius: 12px; text-align: center;">
                <i class="fas fa-info-circle" style="font-size: 1.5rem; margin-bottom: 10px; display: block; color: #1D4ED8;"></i>
                No leave balance found for current year. Please contact HR.
            </div>
            @endif

            <div class="section-title">
                <i class="fas fa-history"></i> Historical Balances
            </div>
            
            <div class="table-container" style="overflow-x: auto;">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Total Days</th>
                            <th>Used Days</th>
                            <th>Remaining</th>
                            <th>Usage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($balances as $balance)
                        <tr>
                            <td><strong>{{ $balance->year }}</strong></td>
                            <td>{{ $balance->total_days }} days</a></td>
                            <td>{{ $balance->used_days }} days</a></td>
                            <td>
                                @php
                                    $remainingClass = 'text-success';
                                    if($balance->remaining_days < 5) $remainingClass = 'text-danger';
                                    elseif($balance->remaining_days < 10) $remainingClass = 'text-warning';
                                @endphp
                                <span class="{{ $remainingClass }}">{{ $balance->remaining_days }} days</span>
                            </a>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div class="progress-small">
                                        @php
                                            $usageColor = $balance->getUsedPercentage() > 80 ? '#DC2626' : ($balance->getUsedPercentage() > 50 ? '#D97706' : '#10B981');
                                        @endphp
                                        <div class="progress-bar-small" style="width: {{ $balance->getUsedPercentage() }}%; background: {{ $usageColor }};"></div>
                                    </div>
                                    <span style="font-size: 0.7rem;">{{ number_format($balance->getUsedPercentage(), 1) }}%</span>
                                </div>
                            </a>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: #9CA3AF;">
                                <i class="fas fa-chart-line" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                                No historical data available
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection