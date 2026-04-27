@extends('layouts.app')

@section('title', 'Audit Logs for ' . $entityType)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Audit Logs for {{ $entityType }} #{{ $entityId }}</h3>
                    <a href="{{ route('audit-logs.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Action</th>
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
                                            {{ $log->user->getFullName() }}
                                        @else
                                            System
                                        @endif
                                    </a></td>
                                    <td>{!! $log->getActionBadge() !!}</a></td>
                                    <td>
                                        @if($log->action == 'update' && $log->old_values && $log->new_values)
                                            @php
                                                $changes = [];
                                                foreach($log->new_values as $key => $value) {
                                                    if(isset($log->old_values[$key]) && $log->old_values[$key] != $value) {
                                                        $changes[] = $key;
                                                    }
                                                }
                                                echo 'Updated: ' . implode(', ', $changes);
                                            @endphp
                                        @elseif($log->action == 'create')
                                            Created record
                                        @elseif($log->action == 'delete')
                                            Deleted record
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