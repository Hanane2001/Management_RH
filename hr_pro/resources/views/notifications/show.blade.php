@extends('layouts.app')

@section('title', 'Notification Details')

@section('content')
<style>
    .details-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .card-header-custom {
        padding: 20px 24px;
        border-bottom: 1px solid #E5E7EB;
        background: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .card-header-custom h3 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 1.25rem;
        color: #1F2937;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .card-header-custom h3 i {
        color: #1D4ED8;
    }
    
    .btn-back {
        background: #F3F4F6;
        color: #374151;
        padding: 8px 16px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-back:hover {
        background: #E5E7EB;
        color: #1F2937;
    }
    
    .card-body-custom {
        padding: 24px;
    }
    
    .notification-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 1.25rem;
        color: #1F2937;
        margin-bottom: 16px;
    }
    
    .meta-info {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #E5E7EB;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-family: 'Roboto', sans-serif;
        font-size: 0.8rem;
        color: #6B7280;
    }
    
    .meta-item i {
        width: 16px;
        color: #9CA3AF;
    }
    
    .badge-status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .badge-read {
        background: #D1FAE5;
        color: #065F46;
    }
    
    .badge-unread {
        background: #FEF3C7;
        color: #D97706;
    }
    
    .badge-type {
        display: inline-block;
        padding: 4px 12px;
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
    
    .message-box {
        background: #F9FAFB;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .message-box p {
        font-family: 'Roboto', sans-serif;
        font-size: 0.9rem;
        color: #374151;
        line-height: 1.6;
        margin: 0;
        white-space: pre-wrap;
    }
    
    .alert-info-custom {
        background: #EFF6FF;
        border-radius: 12px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 24px;
    }
    
    .alert-info-custom i {
        color: #1D4ED8;
    }
    
    .alert-info-custom span {
        font-family: 'Roboto', sans-serif;
        font-size: 0.8rem;
        color: #1E40AF;
    }
    
    .action-buttons {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        flex-wrap: wrap;
    }
    
    .btn-success {
        background: #D1FAE5;
        color: #065F46;
        padding: 10px 20px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    
    .btn-success:hover {
        background: #A7F3D0;
        transform: translateY(-1px);
    }
    
    .btn-warning {
        background: #FEF3C7;
        color: #D97706;
        padding: 10px 20px;
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
    
    .btn-warning:hover {
        background: #FDE68A;
        transform: translateY(-1px);
    }
    
    .btn-danger {
        background: #FEE2E2;
        color: #DC2626;
        padding: 10px 20px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    
    .btn-danger:hover {
        background: #FECACA;
        transform: translateY(-1px);
    }
    
    @media (max-width: 768px) {
        .card-header-custom {
            padding: 16px 20px;
        }
        
        .card-body-custom {
            padding: 20px;
        }
        
        .meta-info {
            flex-direction: column;
            gap: 10px;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-success, .btn-warning, .btn-danger {
            justify-content: center;
        }
    }
</style>

<div class="container-fluid">
    <div class="details-card">
        <div class="card-header-custom">
            <h3>
                <i class="fas fa-bell"></i> Notification Details
            </h3>
            <a href="{{ route('notifications.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
        <div class="card-body-custom">
            <div class="notification-title">
                {{ $notification->title }}
            </div>
            
            <div class="meta-info">
                <div class="meta-item">
                    <i class="fas fa-user"></i>
                    To: <strong>{{ $notification->user->getFullName() }}</strong>
                </div>
                <div class="meta-item">
                    <i class="fas fa-clock"></i>
                    {{ $notification->created_at->format('d/m/Y H:i:s') }}
                </div>
                <div class="meta-item">
                    <i class="fas fa-tag"></i>
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
                <div class="meta-item">
                    <i class="fas fa-check-circle"></i>
                    <span class="badge-status {{ $notification->is_read ? 'badge-read' : 'badge-unread' }}">
                        {{ $notification->is_read ? 'Read' : 'Unread' }}
                    </span>
                </div>
            </div>
            
            <div class="message-box">
                <p>{{ nl2br(e($notification->message)) }}</p>
            </div>
            
            @if($notification->sent_at)
            <div class="alert-info-custom">
                <i class="fas fa-paper-plane"></i>
                <span>Sent at: {{ $notification->sent_at->format('d/m/Y H:i:s') }}</span>
            </div>
            @endif
            
            <div class="action-buttons">
                @if(!$notification->is_read)
                <form method="POST" action="{{ route('notifications.mark-read', $notification) }}">
                    @csrf
                    <button type="submit" class="btn-success">
                        <i class="fas fa-check-circle"></i> Mark as Read
                    </button>
                </form>
                @endif
                @can('update', $notification)
                <a href="{{ route('notifications.edit', $notification) }}" class="btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                @endcan
                @can('delete', $notification)
                <form method="POST" action="{{ route('notifications.destroy', $notification) }}" 
                      onsubmit="return confirm('Delete this notification? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection