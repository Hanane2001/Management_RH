@extends('layouts.app')

@section('title', 'Audit Logs')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Audit Logs</h3>
                    <div class="float-end">
                        <a href="{{ route('audit-logs.dashboard') }}" class="btn btn-info">
                            <i class="fas fa-chart-line"></i> Dashboard
                        </a>
                        <button type="button" class="btn btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#cleanModal">
                            <i class="fas fa-trash"></i> Clean Old Logs
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" action="{{ route('audit-logs.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="user_id" class="form-control">
                                    <option value="">All Users</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->getFullName() }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="action" class="form-control">
                                    <option value="">All Actions</option>
                                    @foreach($actions as $action)
                                    <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                        {{ ucfirst($action) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="entity_type" class="form-control">
                                    <option value="">All Entities</option>
                                    @foreach($entityTypes as $entity)
                                    <option value="{{ $entity }}" {{ request('entity_type') == $entity ? 'selected' : '' }}>
                                        {{ $entity }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="date_from" class="form-control" placeholder="From" value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                    </form>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h5>Total Logs</h5>
                                    <h3>{{ $stats['total'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h5>Today</h5>
                                    <h3>{{ $stats['today'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h5>This Week</h5>
                                    <h3>{{ $stats['this_week'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h5>This Month</h5>
                                    <h3>{{ $stats['this_month'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Entity</th>
                                    <th>Entity ID</th>
                                    <th>Changes</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $log)
                                <tr>
                                    <td>{{ $log->id }}</a></td>
                                    <td>
                                        @if($log->user)
                                        <a href="{{ route('audit-logs.user', $log->user_id) }}">
                                            {{ $log->user->getFullName() }}
                                        </a>
                                        @else
                                            System
                                        @endif
                                    </a></td>
                                    <td>{!! $log->getActionBadge() !!}</a></td>
                                    <td>
                                        <a href="{{ route('audit-logs.entity', ['entityType' => $log->entity_type, 'entityId' => $log->entity_id]) }}">
                                            {{ $log->entity_type }}
                                        </a>
                                    </a></td>
                                    <td>{{ $log->entity_id }}</a></td>
                                    <td>
                                        @if($log->action == 'create')
                                            <span class="text-success">Created record</span>
                                        @elseif($log->action == 'delete')
                                            <span class="text-danger">Deleted record</span>
                                        @elseif($log->action == 'update' && $log->old_values && $log->new_values)
                                            <span class="text-warning">
                                                @php
                                                    $changes = [];
                                                    foreach($log->new_values as $key => $value) {
                                                        if(isset($log->old_values[$key]) && $log->old_values[$key] != $value) {
                                                            $changes[] = $key;
                                                        }
                                                    }
                                                    echo 'Updated: ' . implode(', ', array_slice($changes, 0, 3));
                                                    if(count($changes) > 3) echo '...';
                                                @endphp
                                            </span>
                                        @else
                                            {{ $log->action }}
                                        @endif
                                    </a></td>
                                    <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</a></td>
                                    <td>
                                        <a href="{{ route('audit-logs.show', $log) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </a>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cleanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Clean Old Audit Logs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('audit-logs.clean') }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="days" class="form-label">Delete logs older than (days)</label>
                        <input type="number" class="form-control" name="days" min="1" max="365" required>
                        <small class="text-muted">Recommended: 90 days</small>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        This action cannot be undone. Old logs will be permanently deleted.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Logs</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection