<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Notification extends Model
{
    use Auditable;
    protected $table = 'notifications';
    
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'is_read',
        'sent_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'sent_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function markAsRead()
    {
        $this->is_read = true;
        $this->save();
    }

    public function getTypeBadge()
    {
        $badges = [
            'email' => '<span class="badge bg-info">Email</span>',
            'sms' => '<span class="badge bg-success">SMS</span>',
            'internal' => '<span class="badge bg-primary">Internal</span>'
        ];
        
        return $badges[$this->type] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    public function getStatusBadge()
    {
        if ($this->is_read) {
            return '<span class="badge bg-success">Read</span>';
        }
        return '<span class="badge bg-warning">Unread</span>';
    }

    public function getTimeAgo()
    {
        return $this->created_at->diffForHumans();
    }
}
