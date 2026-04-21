@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Audit Logs</h1>
    
    <div class="row">
        <div class="col-md-3">
            <!-- Statistics Cards -->
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5>Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>Total Logs:</strong> {{ number_format($stats['total']) }}
                    </div>
                    <div class="mb-2">
                        <strong>Today:</strong> {{ $stats['today'] }}
                    </div>
                    <div class="mb-2">
                        <strong>This Week:</strong> {{ $stats['this_week'] }}
                    </div>
                    <div class="mb-2">
                        <strong>This Month:</strong> {{ $stats['this_month'] }}
                    </div>
                </div>
            </div>
            
            <!-- Actions by Type -->
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <h5>By Action</h5>
                </div>
                <div class="card-body">
                    @foreach($stats['by_action'] as $action)
                        <div class="d-flex justify-content-between mb-1">
                            <span>{!! \App\Models\AuditLog::getActionBadgeStatic($action->action) !!}</span>
                            <span class="badge bg-secondary">{{ $action->count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Top Users -->
            <div class="card">
                <div class="card-header bg-warning">
                    <h5>Top Active Users</h5>
                </div>
                <div class="card-body">
                    @foreach($stats['top_users'] as $top)
                        <div class="d-flex justify-content-between mb-1">
                            <span>
                                @if($top->user_id)
                                <a href="{{ route('audit-logs.user', $top->user_id) }}">
                                    {{ $top->user ? $top->user->first_name . ' ' . $top->user->last_name : 'System' }}
                                </a>
                                @else
                                    {{ $top->user ? $top->user->first_name . ' ' . $top->user->last_name : 'System' }}
                                @endif
                            </span>
                            <span class="badge bg-secondary">{{ $top->count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <!-- Filters -->
            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('audit-logs.index') }}" class="row">
                        <div class="col-md-3 mb-2">
                            <label>User</label>
                            <select name="user_id" class="form-control">
                                <option value="">All Users</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->first_name }} {{ $user->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label>Action</label>
                            <select name="action" class="form-control">
                                <option value="">All</option>
                                @foreach($actions as $action)
                                    <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                        {{ ucfirst($action) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label>Entity Type</label>
                            <select name="entity_type" class="form-control">
                                <option value="">All</option>
                                @foreach($entityTypes as $type)
                                    <option value="{{ $type }}" {{ request('entity_type') == $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label>Date From</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label>Date To</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-1 mb-2">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary form-control">Filter</button>
                        </div>
                    </form>
                    
                    <form method="GET" action="{{ route('audit-logs.index') }}" class="row mt-2">
                        <div class="col-md-10">
                            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-secondary w-100">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="mb-3">
                <a href="{{ route('audit-logs.export', request()->query()) }}" class="btn btn-success">Export CSV</a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cleanModal">
                    Clean Old Logs
                </button>
                <a href="{{ route('audit-logs.dashboard') }}" class="btn btn-info">Dashboard</a>
            </div>
            
            <!-- Logs Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Entity</th>
                                    <th>Entity ID</th>
                                    <th>Changes</th>
                                    <th>Date/Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                <tr>
                                    <td>{{ $log->id }}</td>
                                    <td>
                                        @if($log->user)
                                            <a href="{{ route('audit-logs.user', $log->user_id) }}">
                                                {{ $log->user->first_name }} {{ $log->user->last_name }}
                                            </a>
                                        @else
                                            System
                                        @endif
                                    </td>
                                    <td>{!! $log->getActionBadge() !!}</td>
                                    <td>
                                        {{ $log->getEntityIcon() }} {{ $log->entity_type }}
                                    </td>
                                    <td>{{ $log->entity_id ?? '-' }}</td>
                                    <td>{{ $log->getChangesSummary() }}</td>
                                    <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>
                                        <a href="{{ route('audit-logs.show', $log) }}" class="btn btn-sm btn-info">View</a>
                                        @if($log->entity_id)
                                            <a href="{{ route('audit-logs.entity', [$log->entity_type, $log->entity_id]) }}" class="btn btn-sm btn-secondary">History</a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No audit logs found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{ $logs->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Clean Modal -->
<div class="modal fade" id="cleanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('audit-logs.clean') }}">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Clean Old Logs</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Delete logs older than (days)</label>
                        <input type="number" name="days" class="form-control" min="1" max="365" required>
                    </div>
                    <div class="alert alert-warning">
                        This action cannot be undone. Are you sure?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection