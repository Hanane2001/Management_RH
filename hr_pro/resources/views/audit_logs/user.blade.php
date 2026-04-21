@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">
        Activity History: {{ $targetUser->first_name }} {{ $targetUser->last_name }}
    </h1>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date/Time</th>
                            <th>Action</th>
                            <th>Entity Type</th>
                            <th>Entity ID</th>
                            <th>Changes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>{!! $log->getActionBadge() !!}</td>
                            <td>{{ $log->getEntityIcon() }} {{ $log->entity_type }}</td>
                            <td>{{ $log->entity_id ?? '-' }}</td>
                            <td>{{ $log->getChangesSummary() }}</td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No activity found for this user</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $logs->links() }}
        </div>
    </div>
    
    <div class="mt-3">
        <a href="{{ route('audit-logs.index') }}" class="btn btn-secondary">Back to Logs</a>
    </div>
</div>
@endsection