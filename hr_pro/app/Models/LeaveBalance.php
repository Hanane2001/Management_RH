<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    protected $fillable = [
        'employee_id',
        'year',
        'total_days',
        'used_days',
        'remaining_days'
    ];

    protected $casts = [
        'year' => 'integer',
        'total_days' => 'integer',
        'used_days' => 'integer',
        'remaining_days' => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function hasEnoughDays($days)
    {
        return $this->remaining_days >= $days;
    }

    public function useDays($days)
    {
        $this->used_days += $days;
        $this->remaining_days -= $days;
        $this->save();
    }

    public function getUsedPercentage()
    {
        if ($this->total_days == 0) return 0;
        return ($this->used_days / $this->total_days) * 100;
    }

    public function getProgressBar(){
        $percentage = $this->getUsedPercentage();
        $color = $percentage > 80 ? 'danger' : ($percentage > 50 ? 'warning' : 'success');
        return "<div class='progress'><div class='progress-bar bg-{$color}' style='width: {$percentage}%'>{$percentage}%</div></div>";
    }
}
