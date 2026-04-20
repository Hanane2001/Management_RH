@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Notification Details</h1>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>{{ $notification->title }}</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>To:</strong> {{ $notification->user->first_name }} {{ $notification->user->last_name }}
                        ({{ $notification->user->email }})
                    </div>
                    <div class="mb-3">
                        <strong>Type:</strong> {!! $notification->getTypeBadge() !!}
                    </div>
                    <div class="mb-3">
                        <strong>Status:</strong> {!! $notification->getStatusBadge() !!}
                    </div>
                    <div class="mb-3">
                        <strong>Sent at:</strong> {{ $notification->sent_at ? $notification->sent_at->format('d/m/Y H:i:s') : $notification->created_at->format('d/m/Y H:i:s') }}
                    </div>
                    <hr>
                    <div class="mb-3">
                        <strong>Message:</strong>
                        <p class="mt-2">{{ $notification->message }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Actions</h5>
                </div>
                <div class="card-body">
                    @if(!$notification->is_read)
                        <form action="{{ route('notifications.mark-read', $notification) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">Mark as Read</button>
                        </form>
                    @endif
                    
                    @can('update', $notification)
                        <a href="{{ route('notifications.edit', $notification) }}" class="btn btn-warning w-100 mb-2">Edit</a>
                    @endcan
                    
                    @can('delete', $notification)
                        <form action="{{ route('notifications.destroy', $notification) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Delete this notification?')">Delete</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        <a href="{{ route('notifications.index') }}" class="btn btn-secondary">Back to Notifications</a>
    </div>
</div>
@endsection