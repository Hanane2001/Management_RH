<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Department extends Model
{
    use Auditable;
    protected $fillable = [
        'name',
        'description',
        'manager_id',
    ];

    public function manager(){
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function employees(){
        return $this->hasMany(User::class);
    }

    public function getEmployeeCount(){
        return $this->employees()->count();
    }
}
