<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Contract;
use App\Models\Department;
use App\Models\Evaluation;
use App\Models\Role;
use App\Traits\Auditable;

class User extends Authenticatable
{
    use Auditable;
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    const ROLE_ADMIN = 1;
    const ROLE_MANAGER = 2;
    const ROLE_EMPLOYEE = 3;
    const ROLE_USER = 4;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'address',
        'birth_date',
        'id_number',
        'social_security_number',
        'role_id',
        'department_id',
        'otp_code',
        'otp_expires_at',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp_code'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime',
        'birth_date' => 'date',
        'password' => 'hashed',
        'is_active' => 'boolean'
    ];
    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function contracts(){
        return $this->hasMany(Contract::class, 'employee_id');
    }
    public function leaveBalances(){
        return $this->hasMany(LeaveBalance::class, 'employee_id');
    }

    public function leaves(){
        return $this->hasMany(Leave::class, 'employee_id');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'employee_id');
    }

    public function evaluationsGiven()
    {
        return $this->hasMany(Evaluation::class, 'evaluator_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'employee_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'employee_id');
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'employee_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function unreadNotifications()
    {
        return $this->hasMany(Notification::class, 'user_id')->where('is_read', false);
    }

    public function isAdmin(): bool{
        return $this->role_id === self::ROLE_ADMIN;
    }

    public function isManager(): bool{
        return $this->role_id === self::ROLE_MANAGER;
    }

    public function isEmployee(): bool{
        return $this->role_id === self::ROLE_EMPLOYEE;
    }

    public function isUser(): bool
    {
        return $this->role_id === self::ROLE_USER;
    }

    public function getCurrentLeaveBalance(){
        return $this->leaveBalances()->where('year', date('Y'))->first();
    }

    public function getTotalRemainingDays(){
        $balance = $this->getCurrentLeaveBalance();
        return $balance ? $balance->remaining_days : 0;
    }

    public function getFullName(){
        return $this->first_name . ' ' . $this->last_name;
    }
}
