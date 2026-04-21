<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Traits\Auditable;

class Contract extends Model
{
    use Auditable;
    protected $fillable = [
        'employee_id',
        'type',
        'base_salary',
        'bonus',
        'position',
        'start_date',
        'end_date',
        'document_path'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'base_salary' => 'decimal:2',
        'bonus' => 'decimal:2'
    ];

    public function employee(){
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function isActive(): bool{
        return !$this->end_date || $this->end_date > now();
    }

    public function getTotalSalary(){
        return $this->base_salary + $this->bonus;
    }
}
