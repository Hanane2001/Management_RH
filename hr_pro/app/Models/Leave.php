<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Leave extends Model
{
    use Auditable;
    protected $fillable = [
        'employee_id',
        'start_date',
        'end_date',
        'duration',
        'type',
        'status',
        'reason',
        'request_date',
        'processed_date',
        'processed_by'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'request_date' => 'date',
        'processed_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function getStatusBadge(){
        return match($this->status) {
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'approved' => '<span class="badge bg-success">Approved</span>',
            'rejected' => '<span class="badge bg-danger">Rejected</span>',
            default => '<span class="badge bg-secondary">Unknown</span>'
        };
    }
}
