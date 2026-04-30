<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use Carbon\Carbon;

class Attendance extends Model
{
    use Auditable;
    protected $fillable = [
        'employee_id',
        'date',
        'check_in',
        'check_out',
        'hours_worked',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'hours_worked' => 'decimal:2'
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function calculateHoursWorked()
    {
        if ($this->check_in && $this->check_out) {
            $checkIn = Carbon::parse($this->check_in);
            $checkOut = Carbon::parse($this->check_out);
            $hours = $checkOut->diffInHours($checkIn) + ($checkOut->diffInMinutes($checkIn) % 60) / 60;
            $this->hours_worked = round($hours, 2);
            $this->save();
        }
        return $this->hours_worked ?? 0;
    }

    public function getStatusBadge()
    {
        $badges = [
            'present' => '<span class="badge bg-success">Present</span>',
            'absent' => '<span class="badge bg-danger">Absent</span>',
            'late' => '<span class="badge bg-warning">Late</span>',
            'half-day' => '<span class="badge bg-info">Half Day</span>'
        ];
        
        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    public function isLate()
    {
        if ($this->check_in) {
            $checkInTime = Carbon::parse($this->check_in);
            $expectedTime = Carbon::parse($this->date->format('Y-m-d') . ' 09:00:00');
            return $checkInTime > $expectedTime;
        }
        return false;
    }

    public function getCheckInFormatted()
    {
        return $this->check_in ? Carbon::parse($this->check_in)->format('H:i:s') : '--:--';
    }

    public function getCheckOutFormatted()
    {
        return $this->check_out ? Carbon::parse($this->check_out)->format('H:i:s') : '--:--';
    }
}
