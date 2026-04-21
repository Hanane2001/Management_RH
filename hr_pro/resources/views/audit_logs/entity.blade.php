@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">
        History for {{ $entityType }} #{{ $entityId }}
    </h1>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date/Time</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Changes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>
                                @if($log->user)
                                    {{ $log->user->first_name }} {{ $log->user->last_name }}
                                @else
                                    System
                                @endif
                            </td>
                            <td>{!! $log->getActionBadge() !!}</td>
                            <td>{{ $log->getChangesSummary() }}</td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No history found for this entity</td>
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