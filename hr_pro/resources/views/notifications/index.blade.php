@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5>Filters</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('notifications.index', ['filter' => 'all']) }}" 
                           class="list-group-item list-group-item-action {{ $filter == 'all' ? 'active' : '' }}">
                            <i class="fas fa-bell"></i> All Notifications
                            <span class="badge bg-secondary float-end">{{ $stats['total'] }}</span>
                        </a>
                        <a href="{{ route('notifications.index', ['filter' => 'unread']) }}" 
                           class="list-group-item list-group-item-action {{ $filter == 'unread' ? 'active' : '' }}">
                            <i class="fas fa-envelope"></i> Unread
                            <span class="badge bg-warning float-end">{{ $stats['unread'] }}</span>
                        </a>
                        <a href="{{ route('notifications.index', ['filter' => 'read']) }}" 
                           class="list-group-item list-group-item-action {{ $filter == 'read' ? 'active' : '' }}">
                            <i class="fas fa-check-circle"></i> Read
                            <span class="badge bg-success float-end">{{ $stats['read'] }}</span>
                        </a>
                    </div>
                    <hr>
                    <div class="d-grid gap-2">
                        <form method="POST" action="{{ route('notifications.mark-all-read') }}">
                            @csrf
                            <button type="submit" class="btn btn-info w-100">
                                <i class="fas fa-check-double"></i> Mark All as Read
                            </button>
                        </form>
                        <form method="POST" action="{{ route('notifications.delete-all') }}" 
                              onsubmit="return confirm('Delete all notifications?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i> Delete All
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5>Notifications</h5>
                    @can('create', App\Models\Notification::class)
                    <a href="{{ route('notifications.create') }}" class="btn btn-primary float-end">
                        <i class="fas fa-plus"></i> Send Notification
                    </a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @forelse($notifications as $notification)
                        <div class="list-group-item list-group-item-action {{ !$notification->is_read ? 'bg-light' : '' }}">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">
                                    {{ $notification->title }}
                                    @if(!$notification->is_read)
                                    <span class="badge bg-primary">New</span>
                                    @endif
                                </h5>
                                <small>{{ $notification->getTimeAgo() }}</small>
                            </div>
                            <p class="mb-1">{{ Str::limit($notification->message, 150) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div>
                                    <span class="badge bg-{{ $notification->type == 'email' ? 'info' : ($notification->type == 'sms' ? 'success' : 'primary') }}">
                                        {{ ucfirst($notification->type) }}
                                    </span>
                                </div>
                                <div>
                                    <a href="{{ route('notifications.show', $notification) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    @if(!$notification->is_read)
                                    <form method="POST" action="{{ route('notifications.mark-read', $notification) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i> Mark as Read
                                        </button>
                                    </form>
                                    @endif
                                    <form method="POST" action="{{ route('notifications.destroy', $notification) }}" class="d-inline" 
                                          onsubmit="return confirm('Delete this notification?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-bell-slash fa-3x mb-3"></i>
                            <p>No notifications found</p>
                        </div>
                        @endforelse
                    </div>
                    <div class="mt-3">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection