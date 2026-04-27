@extends('layouts.app')

@section('title', 'Audit Logs for ' . $targetUser->getFullName())

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Audit Logs for {{ $targetUser->getFullName() }}</h3>
                    <a href="{{ route('audit-logs.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <strong>User Information:</strong><br>
                        Email: {{ $targetUser->email }}<br>
                        Role: {{ ucfirst($targetUser->role->name ?? 'N/A') }}<br>
                        Department: {{ $targetUser->department->name ?? 'N/A' }}
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
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
                                    <td>{!! $log->getActionBadge() !!}</a></td>
                                    <td>{{ $log->entity_type }}</a></td>
                                    <td>{{ $log->entity_id }}</a></td>
                                    <td>
                                        @if($log->action == 'update' && $log->old_values && $log->new_values)
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
                                        @elseif($log->action == 'create')
                                            Created new {{ $log->entity_type }}
                                        @elseif($log->action == 'delete')
                                            Deleted {{ $log->entity_type }}
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
@endsection