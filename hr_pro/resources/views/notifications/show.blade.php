@extends('layouts.app')

@section('title', 'Notification Details')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Notification Details</h3>
                    <a href="{{ route('notifications.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h4>{{ $notification->title }}</h4>
                        <div class="text-muted mb-3">
                            <i class="fas fa-user"></i> To: {{ $notification->user->getFullName() }} |
                            <i class="fas fa-clock"></i> {{ $notification->created_at->format('d/m/Y H:i:s') }} |
                            <i class="fas fa-tag"></i> 
                            <span class="badge bg-{{ $notification->type == 'email' ? 'info' : ($notification->type == 'sms' ? 'success' : 'primary') }}">
                                {{ ucfirst($notification->type) }}
                            </span>
                            @if($notification->is_read)
                            <span class="badge bg-success">Read</span>
                            @else
                            <span class="badge bg-warning">Unread</span>
                            @endif
                        </div>
                        <div class="card bg-light">
                            <div class="card-body">
                                {{ nl2br(e($notification->message)) }}
                            </div>
                        </div>
                    </div>
                    
                    @if($notification->sent_at)
                    <div class="alert alert-info">
                        <i class="fas fa-paper-plane"></i> Sent at: {{ $notification->sent_at->format('d/m/Y H:i:s') }}
                    </div>
                    @endif
                    
                    <div class="d-flex justify-content-end gap-2">
                        @if(!$notification->is_read)
                        <form method="POST" action="{{ route('notifications.mark-read', $notification) }}">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> Mark as Read
                            </button>
                        </form>
                        @endif
                        @can('update', $notification)
                        <a href="{{ route('notifications.edit', $notification) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        @endcan
                        @can('delete', $notification)
                        <form method="POST" action="{{ route('notifications.destroy', $notification) }}" 
                              onsubmit="return confirm('Delete this notification?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection