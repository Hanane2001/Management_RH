@extends('layouts.app')

@section('title', 'Audit Logs for ' . $targetUser->getFullName())

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
    
    .info-alert {
        background: #EFF6FF;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 24px;
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }
    
    .info-alert-item {
        display: flex;
        flex-direction: column;
    }
    
    .info-alert-label {
        font-family: 'Inter', sans-serif;
        font-size: 0.7rem;
        font-weight: 500;
        color: #6B7280;
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    
    .info-alert-value {
        font-family: 'Roboto', sans-serif;
        font-size: 0.9rem;
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
    
    .table-modern tbody td {
        padding: 12px 16px;
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
    
    .entity-link {
        color: #1D4ED8;
        text-decoration: none;
        font-weight: 500;
    }
    
    .entity-link:hover {
        text-decoration: underline;
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
    
    .empty-state {
        text-align: center;
        padding: 60px;
        color: #9CA3AF;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 15px;
        display: block;
    }
    
    @media (max-width: 768px) {
        .info-alert {
            flex-direction: column;
            gap: 12px;
        }
        
        .table-modern thead th,
        .table-modern tbody td {
            padding: 8px 12px;
        }
    }
</style>

<div class="container-fluid">
    <div class="page-header">
        <h1 class="page-title">Audit Logs for {{ $targetUser->getFullName() }}</h1>
        <a href="{{ route('audit-logs.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Logs
        </a>
    </div>
    
    <div class="info-alert">
        <div class="info-alert-item">
            <span class="info-alert-label"><i class="fas fa-envelope"></i> Email</span>
            <span class="info-alert-value">{{ $targetUser->email }}</span>
        </div>
        <div class="info-alert-item">
            <span class="info-alert-label"><i class="fas fa-tag"></i> Role</span>
            <span class="info-alert-value">{{ ucfirst($targetUser->role->name ?? 'N/A') }}</span>
        </div>
        <div class="info-alert-item">
            <span class="info-alert-label"><i class="fas fa-building"></i> Department</span>
            <span class="info-alert-value">{{ $targetUser->department->name ?? 'N/A' }}</span>
        </div>
        <div class="info-alert-item">
            <span class="info-alert-label"><i class="fas fa-calendar-alt"></i> Member Since</span>
            <span class="info-alert-value">{{ $targetUser->created_at->format('d/m/Y') }}</span>
        </div>
    </div>
    
    <div class="data-card">
        <div class="table-container">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Entity</th>
                        <th>Entity ID</th>
                        <th>Changes</th>
                        <th>Created At</th>
                        <th style="width: 50px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
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
                            <a href="{{ route('audit-logs.entity', ['entityType' => $log->entity_type, 'entityId' => $log->entity_id]) }}" class="entity-link">
                                {{ $log->entity_type }}
                            </a>
                        </td>
                        <td>{{ $log->entity_id }}</td>
                        <td>
                            @if($log->action == 'create')
                                <span style="color: #10B981;"><i class="fas fa-plus-circle"></i> Created</span>
                            @elseif($log->action == 'delete')
                                <span style="color: #EF4444;"><i class="fas fa-trash-alt"></i> Deleted</span>
                            @elseif($log->action == 'update' && $log->old_values && $log->new_values)
                                @php
                                    $changes = [];
                                    foreach($log->new_values as $key => $value) {
                                        if(isset($log->old_values[$key]) && $log->old_values[$key] != $value) {
                                            if(!in_array($key, ['password', 'remember_token', 'otp_code'])) {
                                                $changes[] = $key;
                                            }
                                        }
                                    }
                                @endphp
                                <span style="color: #F59E0B;">
                                    <i class="fas fa-edit"></i> Updated: 
                                    {{ implode(', ', array_slice($changes, 0, 2)) }}
                                    @if(count($changes) > 2) +{{ count($changes) - 2 }} more @endif
                                </span>
                            @elseif(in_array($log->action, ['login', 'logout', 'login_success']))
                                <span class="text-muted"><i class="fas fa-shield-alt"></i> Authentication event</span>
                            @else
                                <span class="text-muted">{{ $log->action }}</span>
                            @endif
                        </td>
                        <td style="white-space: nowrap;">
                            <i class="fas fa-clock text-muted"></i> {{ $log->created_at->format('d/m/Y H:i:s') }}
                        </td>
                        <td>
                            <a href="{{ route('audit-logs.show', $log) }}" class="btn-view" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <i class="fas fa-history"></i>
                            No audit logs found for this user
                        </tr>
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