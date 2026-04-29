@extends('layouts.app')

@section('title', 'Audit Logs for ' . $entityType)

@section('content')
<style>
    .page-header {
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
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
    
    .page-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #EFF6FF;
        color: #1D4ED8;
        padding: 6px 12px;
        border-radius: 20px;
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        font-weight: 500;
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
    
    .badge-action {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .badge-create {
        background: #D1FAE5;
        color: #065F46;
    }
    
    .badge-update {
        background: #FEF3C7;
        color: #D97706;
    }
    
    .badge-delete {
        background: #FEE2E2;
        color: #991B1B;
    }
    
    .badge-login {
        background: #EFF6FF;
        color: #1D4ED8;
    }
    
    .badge-other {
        background: #F3F4F6;
        color: #6B7280;
    }
    
    .btn-view {
        background: #EFF6FF;
        color: #1D4ED8;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 0.75rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
    }
    
    .btn-view:hover {
        background: #DBEAFE;
    }
    
    .pagination-container {
        padding: 16px 20px;
        border-top: 1px solid #E5E7EB;
    }
    
    .changes-list {
        font-size: 0.8rem;
        color: #6B7280;
    }
    
    .changes-list strong {
        color: #374151;
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
        <div>
            <h1 class="page-title">Audit Logs</h1>
            <div class="page-badge" style="margin-top: 8px;">
                <i class="fas fa-database"></i> {{ $entityType }} #{{ $entityId }}
            </div>
        </div>
        <a href="{{ route('audit-logs.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Logs
        </a>
    </div>
    
    <div class="data-card">
        <div class="table-container">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Action</th>
                        <th>Changes</th>
                        <th>Created At</th>
                        <th style="width: 60px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>
                            <strong>{{ $log->user ? $log->user->getFullName() : 'System' }}</strong>
                            @if($log->user && $log->user->email)
                            <div class="text-muted" style="font-size: 0.7rem;">{{ $log->user->email }}</div>
                            @endif
                        </td>
                        <td>
                            @php
                                $badgeClass = match($log->action) {
                                    'create' => 'badge-create',
                                    'update' => 'badge-update',
                                    'delete' => 'badge-delete',
                                    'login', 'logout', 'login_success' => 'badge-login',
                                    default => 'badge-other'
                                };
                            @endphp
                            <span class="badge-action {{ $badgeClass }}">
                                <i class="fas 
                                    @if($log->action == 'create') fa-plus
                                    @elseif($log->action == 'update') fa-edit
                                    @elseif($log->action == 'delete') fa-trash
                                    @elseif($log->action == 'login') fa-sign-in-alt
                                    @elseif($log->action == 'logout') fa-sign-out-alt
                                    @else fa-clock @endif"></i>
                                {{ ucfirst($log->action) }}
                            </span>
                        </td>
                        <td>
                            @if($log->action == 'update' && $log->old_values && $log->new_values)
                                @php
                                    $changes = [];
                                    foreach($log->new_values as $key => $value) {
                                        if(isset($log->old_values[$key]) && $log->old_values[$key] != $value) {
                                            if(!in_array($key, ['password', 'remember_token', 'otp_code'])) {
                                                $changes[] = '<strong>' . ucfirst(str_replace('_', ' ', $key)) . '</strong>';
                                            }
                                        }
                                    }
                                @endphp
                                @if(!empty($changes))
                                    <div class="changes-list">Updated: {!! implode(', ', $changes) !!}</div>
                                @else
                                    <span class="text-muted">Field changes</span>
                                @endif
                            @elseif($log->action == 'create')
                                <span class="text-muted"><i class="fas fa-plus-circle"></i> Created record</span>
                            @elseif($log->action == 'delete')
                                <span class="text-muted"><i class="fas fa-trash-alt"></i> Deleted record</span>
                            @else
                                <span class="text-muted">{{ $log->action }}</span>
                            @endif
                        </td>
                        <td style="white-space: nowrap;">
                            <i class="fas fa-clock text-muted" style="font-size: 0.7rem;"></i>
                            <span>{{ $log->created_at->format('d/m/Y H:i:s') }}</span>
                        </td>
                        <td>
                            <a href="{{ route('audit-logs.show', $log) }}" class="btn-view" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty-state" style="text-align: center; padding: 60px;">
                            <i class="fas fa-history" style="font-size: 3rem; color: #9CA3AF; margin-bottom: 15px; display: block;"></i>
                            No audit logs found for this entity
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
        <div class="pagination-container">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection