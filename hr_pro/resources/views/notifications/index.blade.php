@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Notifications</h1>
    
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5>Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>Total:</strong> {{ $stats['total'] }}
                    </div>
                    <div class="mb-2">
                        <strong>Unread:</strong> 
                        <span class="badge bg-warning">{{ $stats['unread'] }}</span>
                    </div>
                    <div class="mb-2">
                        <strong>Read:</strong> 
                        <span class="badge bg-success">{{ $stats['read'] }}</span>
                    </div>
                    <hr>
                    <div class="mb-2">
                        <strong>Email:</strong> {{ $stats['email_count'] }}
                    </div>
                    <div class="mb-2">
                        <strong>SMS:</strong> {{ $stats['sms_count'] }}
                    </div>
                    <div class="mb-2">
                        <strong>Internal:</strong> {{ $stats['internal_count'] }}
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Filters</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('notifications.index', ['filter' => 'all']) }}" 
                           class="list-group-item list-group-item-action {{ $filter == 'all' ? 'active' : '' }}">
                            All Notifications
                            <span class="badge bg-secondary float-end">{{ $stats['total'] }}</span>
                        </a>
                        <a href="{{ route('notifications.index', ['filter' => 'unread']) }}" 
                           class="list-group-item list-group-item-action {{ $filter == 'unread' ? 'active' : '' }}">
                            Unread
                            <span class="badge bg-warning float-end">{{ $stats['unread'] }}</span>
                        </a>
                        <a href="{{ route('notifications.index', ['filter' => 'read']) }}" 
                           class="list-group-item list-group-item-action {{ $filter == 'read' ? 'active' : '' }}">
                            Read
                            <span class="badge bg-success float-end">{{ $stats['read'] }}</span>
                        </a>
                    </div>
                    
                    <hr>
                    
                    <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary w-100 mb-2">Mark All as Read</button>
                    </form>
                    
                    <form action="{{ route('notifications.delete-all') }}" method="POST" onsubmit="return confirm('Delete all notifications?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger w-100">Delete All</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            @can('create', App\Models\Notification::class)
                <div class="mb-3">
                    <a href="{{ route('notifications.create') }}" class="btn btn-primary">+ New Notification</a>
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#bulkModal">
                        Send Bulk
                    </button>
                </div>
            @endcan
            
            <div class="card">
                <div class="card-body">
                    @forelse($notifications as $notification)
                        <div class="notification-item {{ !$notification->is_read ? 'bg-light' : '' }}" 
                             style="padding: 15px; border-bottom: 1px solid #eee;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">
                                        @if(!$notification->is_read)
                                            <span class="badge bg-primary me-2">New</span>
                                        @endif
                                        {{ $notification->title }}
                                        {!! $notification->getTypeBadge() !!}
                                    </h6>
                                    <p class="mb-1">{{ Str::limit($notification->message, 100) }}</p>
                                    <small class="text-muted">
                                        To: {{ $notification->user->first_name }} {{ $notification->user->last_name }} | 
                                        {{ $notification->getTimeAgo() }}
                                    </small>
                                </div>
                                <div class="btn-group">
                                    <a href="{{ route('notifications.show', $notification) }}" class="btn btn-sm btn-info">View</a>
                                    @can('update', $notification)
                                        <a href="{{ route('notifications.edit', $notification) }}" class="btn btn-sm btn-warning">Edit</a>
                                    @endcan
                                    @can('delete', $notification)
                                        <form action="{{ route('notifications.destroy', $notification) }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this notification?')">Delete</button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <p class="text-muted">No notifications found</p>
                        </div>
                    @endforelse
                    
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Notification Modal -->
@can('create', App\Models\Notification::class)
<div class="modal fade" id="bulkModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('notifications.send-bulk') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Send Bulk Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Select Users</label>
                        <select name="user_ids[]" class="form-control" multiple size="5" required>
                            @foreach($notifications->getCollection()->pluck('user')->unique() as $user)
                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                            @endforeach
                        </select>
                        <small>Hold Ctrl to select multiple</small>
                    </div>
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Message</label>
                        <textarea name="message" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Type</label>
                        <select name="type" class="form-control" required>
                            <option value="internal">Internal</option>
                            <option value="email">Email</option>
                            <option value="sms">SMS</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
@endsection