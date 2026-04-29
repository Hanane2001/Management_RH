@extends('layouts.app')

@section('title', 'Audit Logs')

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
    
    .action-buttons {
        display: flex;
        gap: 10px;
    }
    
    .btn-info {
        background: #EFF6FF;
        color: #1D4ED8;
        padding: 8px 16px;
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
    
    .btn-info:hover {
        background: #DBEAFE;
    }
    
    .btn-danger {
        background: #FEE2E2;
        color: #DC2626;
        padding: 8px 16px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    
    .btn-danger:hover {
        background: #FECACA;
    }
    
    /* Filters */
    .filters-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
        margin-bottom: 24px;
    }
    
    .filters-body {
        padding: 20px;
    }
    
    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 15px;
    }
    
    .filter-group {
        display: flex;
        flex-direction: column;
    }
    
    .filter-label {
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 500;
        color: #6B7280;
        margin-bottom: 5px;
        text-transform: uppercase;
    }
    
    .filter-input, .filter-select {
        padding: 8px 12px;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        font-family: 'Roboto', sans-serif;
        font-size: 0.85rem;
        background: white;
        outline: none;
    }
    
    .filter-input:focus, .filter-select:focus {
        border-color: #1D4ED8;
        box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1);
    }
    
    .btn-filter {
        background: #1D4ED8;
        color: white;
        padding: 8px 20px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        margin-top: auto;
    }
    
    .btn-filter:hover {
        background: #1E3A8A;
    }
    
    /* Stats Mini Cards */
    .stats-mini-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }
    
    .stat-mini-card {
        background: white;
        border-radius: 16px;
        padding: 16px;
        border: 1px solid #E5E7EB;
        text-align: center;
    }
    
    .stat-mini-title {
        font-family: 'Inter', sans-serif;
        font-size: 0.7rem;
        font-weight: 500;
        color: #6B7280;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    
    .stat-mini-value {
        font-family: 'Inter', sans-serif;
        font-size: 1.5rem;
        font-weight: 700;
        color: #1F2937;
    }
    
    /* Data Card */
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
    
    /* Badges */
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
    
    @media (max-width: 768px) {
        .stats-mini-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        
        .filter-grid {
            grid-template-columns: 1fr;
        }
        
        .table-modern thead th,
        .table-modern tbody td {
            padding: 8px 12px;
        }
    }
</style>

<div class="container-fluid">
    <div class="page-header">
        <h1 class="page-title">Audit Logs</h1>
        <div class="action-buttons">
            <a href="{{ route('audit-logs.dashboard') }}" class="btn-info">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <button type="button" class="btn-danger" data-bs-toggle="modal" data-bs-target="#cleanModal">
                <i class="fas fa-trash"></i> Clean Old Logs
            </button>
        </div>
    </div>
    
    <div class="filters-card">
        <div class="filters-body">
            <form method="GET" action="{{ route('audit-logs.index') }}">
                <div class="filter-grid">
                    <div class="filter-group">
                        <label class="filter-label">Search</label>
                        <input type="text" name="search" class="filter-input" placeholder="Search..." value="{{ request('search') }}">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">User</label>
                        <select name="user_id" class="filter-select">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->getFullName() }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Action</label>
                        <select name="action" class="filter-select">
                            <option value="">All Actions</option>
                            @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                {{ ucfirst($action) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Entity Type</label>
                        <select name="entity_type" class="filter-select">
                            <option value="">All Entities</option>
                            @foreach($entityTypes as $entity)
                            <option value="{{ $entity }}" {{ request('entity_type') == $entity ? 'selected' : '' }}>
                                {{ $entity }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Date From</label>
                        <input type="date" name="date_from" class="filter-input" value="{{ request('date_from') }}">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Date To</label>
                        <input type="date" name="date_to" class="filter-input" value="{{ request('date_to') }}">
                    </div>
                    <div class="filter-group" style="justify-content: flex-end;">
                        <button type="submit" class="btn-filter">
                            <i class="fas fa-filter"></i> Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="stats-mini-grid">
        <div class="stat-mini-card">
            <div class="stat-mini-title">Total Logs</div>
            <div class="stat-mini-value">{{ number_format($stats['total']) }}</div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-mini-title">Today</div>
            <div class="stat-mini-value">{{ number_format($stats['today']) }}</div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-mini-title">This Week</div>
            <div class="stat-mini-value">{{ number_format($stats['this_week']) }}</div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-mini-title">This Month</div>
            <div class="stat-mini-value">{{ number_format($stats['this_month']) }}</div>
        </div>
    </div>
    
    <div class="data-card">
        <div class="table-container">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>User</th>
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
                            @if($log->user)
                            <a href="{{ route('audit-logs.user', $log->user_id) }}" class="entity-link">
                                <strong>{{ $log->user->getFullName() }}</strong>
                            </a>
                            @else
                            <strong>System</strong>
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
                        <td colspan="7" class="empty-state" style="text-align: center; padding: 60px;">
                            <i class="fas fa-history" style="font-size: 3rem; color: #9CA3AF; margin-bottom: 15px; display: block;"></i>
                            No audit logs found
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

<div class="modal fade" id="cleanModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content-custom" style="background: white; border-radius: 20px; overflow: hidden;">
            <div class="modal-header-custom" style="padding: 20px 24px; border-bottom: 1px solid #E5E7EB; background: #F9FAFB; display: flex; justify-content: space-between; align-items: center;">
                <h5 style="font-family: 'Inter', sans-serif; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-trash-alt" style="color: #DC2626;"></i> Clean Old Audit Logs
                </h5>
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
            </div>
            <form method="POST" action="{{ route('audit-logs.clean') }}">
                @csrf
                @method('DELETE')
                <div class="modal-body-custom" style="padding: 24px;">
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-family: 'Inter', sans-serif; font-size: 0.85rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Delete logs older than (days)</label>
                        <input type="number" name="days" class="filter-input" style="width: 100%;" min="1" max="365" placeholder="e.g., 90" required>
                        <small class="text-muted" style="font-family: 'Roboto', sans-serif; font-size: 0.7rem;">Recommended: 90 days</small>
                    </div>
                    <div style="background: #FEF2F2; padding: 12px 16px; border-radius: 12px; display: flex; gap: 10px; align-items: center;">
                        <i class="fas fa-exclamation-triangle" style="color: #DC2626;"></i>
                        <span style="font-family: 'Roboto', sans-serif; font-size: 0.8rem; color: #991B1B;">
                            This action cannot be undone. Old logs will be permanently deleted.
                        </span>
                    </div>
                </div>
                <div class="modal-footer-custom" style="padding: 16px 24px; border-top: 1px solid #E5E7EB; background: #F9FAFB; display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal" style="background: #F3F4F6; color: #374151; padding: 8px 20px; border-radius: 10px; border: none; cursor: pointer; font-family: 'Inter', sans-serif;">Cancel</button>
                    <button type="submit" class="btn-danger" style="background: #DC2626; color: white; padding: 8px 20px; border-radius: 10px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fas fa-trash"></i> Delete Logs
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection