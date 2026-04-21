<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Payroll extends Model
{
    use Auditable;
    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'base_salary',
        'overtime_hours',
        'bonuses',
        'allowances',
        'deductions',
        'net_pay',
        'status',
        'document_path'
    ];

    protected $casts = [
        'base_salary' => 'decimal:2',
        'bonuses' => 'decimal:2',
        'allowances' => 'decimal:2',
        'deductions' => 'decimal:2',
        'net_pay' => 'decimal:2',
        'overtime_hours' => 'integer'
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function calculateNetPay()
    {
        $total = $this->base_salary + $this->bonuses + $this->allowances;

        if ($this->overtime_hours > 0) {
            $dailyRate = $this->base_salary / 22; // 22 working days per month
            $hourlyRate = $dailyRate / 8;
            $overtimePay = $this->overtime_hours * $hourlyRate * 1.5;
            $total += $overtimePay;
        }
        
        $this->net_pay = $total - $this->deductions;
        $this->save();
        
        return $this->net_pay;
    }

    public function getStatusBadge()
    {
        $badges = [
            'draft' => '<span class="badge bg-secondary">Draft</span>',
            'generated' => '<span class="badge bg-info">Generated</span>',
            'approved' => '<span class="badge bg-success">Approved</span>',
            'paid' => '<span class="badge bg-primary">Paid</span>'
        ];
        
        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    public function getMonthName()
    {
        $months = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];
        
        return $months[$this->month] ?? 'Unknown';
    }

    public function getTotalSalary()
    {
        $total = $this->base_salary + $this->bonuses + $this->allowances;
        
        if ($this->overtime_hours > 0) {
            $dailyRate = $this->base_salary / 22;
            $hourlyRate = $dailyRate / 8;
            $total += $this->overtime_hours * $hourlyRate * 1.5;
        }
        
        return $total;
    }

    public function canBeApproved()
    {
        return $this->status === 'generated';
    }

    public function canBePaid()
    {
        return $this->status === 'approved';
    }
}
