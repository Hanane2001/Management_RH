@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<style>
    /* Layout */
    .notifications-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 24px;
    }
    
    /* Sidebar Filters */
    .filters-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
    }
    
    .card-header-custom {
        padding: 16px 20px;
        border-bottom: 1px solid #E5E7EB;
        background: #F9FAFB;
    }
    
    .card-header-custom h5 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.95rem;
        color: #1F2937;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .card-header-custom h5 i {
        color: #1D4ED8;
    }
    
    .card-body-custom {
        padding: 16px 0;
    }
    
    .filter-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    
    .filter-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 20px;
        text-decoration: none;
        color: #374151;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        transition: all 0.2s;
    }
    
    .filter-item:hover {
        background: #F9FAFB;
    }
    
    .filter-item.active {
        background: #EFF6FF;
        color: #1D4ED8;
        border-left: 3px solid #1D4ED8;
    }
    
    .filter-badge {
        background: #F3F4F6;
        color: #6B7280;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .filter-item.active .filter-badge {
        background: #DBEAFE;
        color: #1D4ED8;
    }
    
    .divider {
        height: 1px;
        background: #E5E7EB;
        margin: 12px 0;
    }
    
    .action-buttons-sidebar {
        padding: 16px 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .btn-sidebar {
        padding: 10px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        width: 100%;
    }
    
    .btn-info {
        background: #EFF6FF;
        color: #1D4ED8;
    }
    
    .btn-info:hover {
        background: #DBEAFE;
    }
    
    .btn-danger {
        background: #FEE2E2;
        color: #DC2626;
    }
    
    .btn-danger:hover {
        background: #FECACA;
    }
    
    /* Main Content */
    .notifications-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
    }
    
    .notifications-header {
        padding: 16px 20px;
        border-bottom: 1px solid #E5E7EB;
        background: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .notifications-header h5 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.95rem;
        color: #1F2937;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-primary-custom {
        background: #1D4ED8;
        color: white;
        padding: 8px 16px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    
    .btn-primary-custom:hover {
        background: #1E3A8A;
        transform: translateY(-1px);
        color: white;
    }
    
    /* Notification Item */
    .notification-item {
        padding: 16px 20px;
        border-bottom: 1px solid #F3F4F6;
        transition: all 0.2s;
    }
    
    .notification-item:hover {
        background: #F9FAFB;
    }
    
    .notification-item.unread {
        background: #FEFCE8;
        border-left: 3px solid #F59E0B;
    }
    
    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 8px;
    }
    
    .notification-title {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.95rem;
        color: #1F2937;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .badge-new {
        background: #EF4444;
        color: white;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 500;
    }
    
    .notification-date {
        font-family: 'Roboto', sans-serif;
        font-size: 0.7rem;
        color: #9CA3AF;
    }
    
    .notification-message {
        font-family: 'Roboto', sans-serif;
        font-size: 0.85rem;
        color: #6B7280;
        margin-bottom: 12px;
        line-height: 1.4;
    }
    
    .notification-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .badge-type {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .badge-email {
        background: #EFF6FF;
        color: #1D4ED8;
    }
    
    .badge-sms {
        background: #F3E8FF;
        color: #7E22CE;
    }
    
    .badge-internal {
        background: #D1FAE5;
        color: #065F46;
    }
    
    .action-group {
        display: flex;
        gap: 6px;
    }
    
    .btn-icon {
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 0.75rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    
    .btn-view {
        background: #EFF6FF;
        color: #1D4ED8;
    }
    
    .btn-view:hover {
        background: #DBEAFE;
    }
    
    .btn-read {
        background: #D1FAE5;
        color: #065F46;
    }
    
    .btn-read:hover {
        background: #A7F3D0;
    }
    
    .btn-delete-icon {
        background: #FEE2E2;
        color: #DC2626;
    }
    
    .btn-delete-icon:hover {
        background: #FECACA;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #9CA3AF;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 15px;
        display: block;
    }
    
    /* Pagination */
    .pagination-container {
        padding: 16px 20px;
        border-top: 1px solid #E5E7EB;
    }
    
    @media (max-width: 768px) {
        .notifications-layout {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .notification-header {
            flex-direction: column;
        }
        
        .notification-footer {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="container-fluid">
    <div class="notifications-layout">
        <!-- Sidebar Filters -->
        <div class="filters-card">
            <div class="card-header-custom">
                <h5>
                    <i class="fas fa-filter"></i> Filters
                </h5>
            </div>
            <div class="card-body-custom">
                <div class="filter-list">
                    <a href="{{ route('notifications.index', ['filter' => 'all']) }}" 
                       class="filter-item {{ $filter == 'all' ? 'active' : '' }}">
                        <span><i class="fas fa-bell"></i> All Notifications</span>
                        <span class="filter-badge">{{ $stats['total'] }}</span>
                    </a>
                    <a href="{{ route('notifications.index', ['filter' => 'unread']) }}" 
                       class="filter-item {{ $filter == 'unread' ? 'active' : '' }}">
                        <span><i class="fas fa-envelope"></i> Unread</span>
                        <span class="filter-badge">{{ $stats['unread'] }}</span>
                    </a>
                    <a href="{{ route('notifications.index', ['filter' => 'read']) }}" 
                       class="filter-item {{ $filter == 'read' ? 'active' : '' }}">
                        <span><i class="fas fa-check-circle"></i> Read</span>
                        <span class="filter-badge">{{ $stats['read'] }}</span>
                    </a>
                </div>
                
                <div class="divider"></div>
                
                <div class="action-buttons-sidebar">
                    <form method="POST" action="{{ route('notifications.mark-all-read') }}" style="width: 100%;">
                        @csrf
                        <button type="submit" class="btn-sidebar btn-info">
                            <i class="fas fa-check-double"></i> Mark All as Read
                        </button>
                    </form>
                    <form method="POST" action="{{ route('notifications.delete-all') }}" 
                          onsubmit="return confirm('Delete all notifications? This action cannot be undone.')" style="width: 100%;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-sidebar btn-danger">
                            <i class="fas fa-trash"></i> Delete All
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Notifications List -->
        <div class="notifications-card">
            <div class="notifications-header">
                <h5>
                    <i class="fas fa-bell"></i> Notifications
                </h5>
                @can('create', App\Models\Notification::class)
                <a href="{{ route('notifications.create') }}" class="btn-primary-custom">
                    <i class="fas fa-plus"></i> Send Notification
                </a>
                @endcan
            </div>
            
            <div style="padding: 0;">
                @forelse($notifications as $notification)
                <div class="notification-item {{ !$notification->is_read ? 'unread' : '' }}">
                    <div class="notification-header">
                        <div class="notification-title">
                            {{ $notification->title }}
                            @if(!$notification->is_read)
                            <span class="badge-new">New</span>
                            @endif
                        </div>
                        <div class="notification-date">
                            <i class="fas fa-clock"></i> {{ $notification->getTimeAgo() }}
                        </div>
                    </div>
                    <div class="notification-message">
                        {{ Str::limit($notification->message, 120) }}
                    </div>
                    <div class="notification-footer">
                        <div>
                            <span class="badge-type 
                                @if($notification->type == 'email') badge-email
                                @elseif($notification->type == 'sms') badge-sms
                                @else badge-internal @endif">
                                <i class="fas 
                                    @if($notification->type == 'email') fa-envelope
                                    @elseif($notification->type == 'sms') fa-mobile-alt
                                    @else fa-bell @endif"></i>
                                {{ ucfirst($notification->type) }}
                            </span>
                        </div>
                        <div class="action-group">
                            <a href="{{ route('notifications.show', $notification) }}" class="btn-icon btn-view" title="View Details">
                                <i class="fas fa-eye"></i> View
                            </a>
                            @if(!$notification->is_read)
                            <form method="POST" action="{{ route('notifications.mark-read', $notification) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn-icon btn-read" title="Mark as Read">
                                    <i class="fas fa-check"></i> Read
                                </button>
                            </form>
                            @endif
                            <form method="POST" action="{{ route('notifications.destroy', $notification) }}" class="d-inline" 
                                  onsubmit="return confirm('Delete this notification?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete-icon" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="fas fa-bell-slash"></i>
                    <p>No notifications found</p>
                </div>
                @endforelse
            </div>
            
            @if($notifications->hasPages())
            <div class="pagination-container">
                {{ $notifications->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection