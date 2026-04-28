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
    
    .card-body-custom {
        padding: 24px;
    }
    
    .current-balance {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #E5E7EB;
    }
    
    .balance-number {
        font-family: 'Inter', sans-serif;
        font-weight: 800;
        font-size: 4rem;
        color: #1D4ED8;
        margin: 20px 0 10px;
    }
    
    .balance-label {
        font-family: 'Roboto', sans-serif;
        font-size: 1.1rem;
        color: #6B7280;
    }
    
    .progress-large {
        height: 30px;
        background: #E5E7EB;
        border-radius: 15px;
        overflow: hidden;
        margin: 20px 0;
    }
    
    .progress-bar-large {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 500;
        color: white;
        transition: width 0.3s ease;
    }
    
    .progress-bar-used {
        background: #EF4444;
    }
    
    .progress-bar-remaining {
        background: #10B981;
    }
    
    .balance-stats {
        display: flex;
        justify-content: space-around;
        margin-top: 15px;
    }
    
    .stat-item {
        text-align: center;
    }
    
    .stat-value {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 1.5rem;
        color: #1F2937;
    }
    
    .stat-label {
        font-family: 'Roboto', sans-serif;
        font-size: 0.8rem;
        color: #6B7280;
    }
    
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        background: #FEF3C7;
        border-radius: 16px;
        color: #D97706;
    }
    
    .empty-state i {
        font-size: 2rem;
        margin-bottom: 10px;
        display: block;
    }
    
    .historical-title {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 1.1rem;
        margin: 25px 0 15px;
        padding-top: 20px;
        border-top: 1px solid #E5E7EB;
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
        height: 6px;
        background: #E5E7EB;
        border-radius: 3px;
        overflow: hidden;
    }
    
    .progress-small-bar {
        height: 100%;
        border-radius: 3px;
    }
    
    @media (max-width: 768px) {
        .balance-number {
            font-size: 3rem;
        }
        
        .balance-stats {
            flex-direction: column;
            gap: 10px;
        }
        
        .card-header-custom {
            padding: 16px 20px;
        }
        
        .card-body-custom {
            padding: 20px;
        }
    }
</style>

<div class="container-fluid">
    <div class="balance-card">
        <div class="card-header-custom">
            <h3>
                <i class="fas fa-calendar-alt"></i> My Leave Balance
            </h3>
        </div>
        <div class="card-body-custom">
            @if($currentBalance)
            <div class="current-balance">
                <div class="balance-number">{{ $currentBalance->remaining_days }}</div>
                <div class="balance-label">Days Remaining in {{ date('Y') }}</div>
                
                @php
                    $usedPercent = ($currentBalance->used_days / $currentBalance->total_days) * 100;
                    $remainingPercent = ($currentBalance->remaining_days / $currentBalance->total_days) * 100;
                @endphp
                
                <div class="progress-large">
                    <div class="progress-bar-large progress-bar-used" style="width: {{ $usedPercent }}%">
                        @if($usedPercent > 15) Used: {{ $currentBalance->used_days }} days @endif
                    </div>
                    <div class="progress-bar-large progress-bar-remaining" style="width: {{ $remainingPercent }}%">
                        @if($remainingPercent > 15) Remaining: {{ $currentBalance->remaining_days }} days @endif
                    </div>
                </div>
                
                <div class="balance-stats">
                    <div class="stat-item">
                        <div class="stat-value">{{ $currentBalance->total_days }}</div>
                        <div class="stat-label">Total Days</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value" style="color: #EF4444;">{{ $currentBalance->used_days }}</div>
                        <div class="stat-label">Used Days</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value" style="color: #10B981;">{{ $currentBalance->remaining_days }}</div>
                        <div class="stat-label">Remaining Days</div>
                    </div>
                </div>
            </div>
            @else
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <p>No leave balance found for the current year.</p>
                <p style="font-size: 0.85rem;">Please contact HR for assistance.</p>
            </div>
            @endif
            
            <div class="historical-title">
                <i class="fas fa-history" style="color: #1D4ED8;"></i> Historical Balances
            </div>
            
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Total Days</th>
                            <th>Used Days</th>
                            <th>Remaining Days</th>
                            <th>Usage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($balances as $balance)
                        <tr>
                            <td>{{ $balance->year }}</a>
                            <td>{{ $balance->total_days }}</a>
                            <td>{{ $balance->used_days }}</a>
                            <td><strong style="color: {{ $balance->remaining_days < 5 ? '#DC2626' : '#10B981' }};">{{ $balance->remaining_days }}</strong></a>
                            <td>
                                @php $percentage = $balance->getUsedPercentage(); @endphp
                                <div class="progress-small">
                                    <div class="progress-small-bar" style="width: {{ $percentage }}%; background: 
                                        @if($percentage > 80) #EF4444
                                        @elseif($percentage > 50) #F59E0B
                                        @else #10B981 @endif">
                                    </div>
                                </div>
                                <small style="font-size: 0.7rem;">{{ number_format($percentage, 1) }}% used</small>
                             </a>
                         </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #9CA3AF; padding: 30px;">
                                <i class="fas fa-inbox"></i> No historical data available
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