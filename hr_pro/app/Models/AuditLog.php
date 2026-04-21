<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public $timestamps = false;
    
    protected $table = 'audit_logs';
    
    protected $fillable = [
        'user_id',
        'action',
        'entity_type',
        'entity_id',
        'old_values',
        'new_values',
        'created_at'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getActionBadge()
    {
        $badges = [
            'create' => '<span class="badge bg-success">Create</span>',
            'update' => '<span class="badge bg-warning">Update</span>',
            'delete' => '<span class="badge bg-danger">Delete</span>',
            'login' => '<span class="badge bg-primary">Login</span>',
            'logout' => '<span class="badge bg-secondary">Logout</span>',
            'login_success' => '<span class="badge bg-success">Login Success</span>',
            'password_reset_request' => '<span class="badge bg-info">Password Reset</span>',
            'approve' => '<span class="badge bg-success">Approve</span>',
            'reject' => '<span class="badge bg-danger">Reject</span>',
            'export' => '<span class="badge bg-info">Export</span>'
        ];
        
        return $badges[$this->action] ?? '<span class="badge bg-secondary">' . ucfirst($this->action) . '</span>';
    }

    public function getEntityIcon()
    {
        $icons = [
            'User' => '👤',
            'Employee' => '👥',
            'Department' => '🏢',
            'Contract' => '📄',
            'Leave' => '🏖️',
            'LeaveBalance' => '⚖️',
            'Payroll' => '💰',
            'Attendance' => '⏰',
            'Evaluation' => '📊',
            'Document' => '📁',
            'Notification' => '🔔'
        ];
        
        return $icons[$this->entity_type] ?? '📝';
    }

    public static function getActionBadgeStatic($action)
    {
        $badges = [
            'create' => '<span class="badge bg-success">Create</span>',
            'update' => '<span class="badge bg-warning">Update</span>',
            'delete' => '<span class="badge bg-danger">Delete</span>',
            'login' => '<span class="badge bg-primary">Login</span>',
            'logout' => '<span class="badge bg-secondary">Logout</span>',
            'login_success' => '<span class="badge bg-success">Login Success</span>',
            'password_reset_request' => '<span class="badge bg-info">Password Reset</span>',
            'approve' => '<span class="badge bg-success">Approve</span>',
            'reject' => '<span class="badge bg-danger">Reject</span>',
            'export' => '<span class="badge bg-info">Export</span>'
        ];
        
        return $badges[$action] ?? '<span class="badge bg-secondary">' . ucfirst($action) . '</span>';
    }

    public function getChangesSummary()
    {
        if ($this->action === 'create') {
            return 'Created new record';
        }
        
        if ($this->action === 'delete') {
            return 'Deleted record';
        }
        
        if ($this->action === 'update' && $this->old_values && $this->new_values) {
            $changes = [];
            foreach ($this->new_values as $key => $value) {
                if (isset($this->old_values[$key]) && $this->old_values[$key] != $value) {
                    $changes[] = $key;
                }
            }
            return 'Updated fields: ' . implode(', ', $changes);
        }
}
}