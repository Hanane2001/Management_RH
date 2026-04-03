<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    const ROLE_ADMIN = 1;
    const ROLE_EMPLOYEE = 3;
    
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

    public function isAdmin(){
        return $this->role->name === 'admin';
    }
}
