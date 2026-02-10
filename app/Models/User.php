<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'unit_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    
    public function suratTerkirim()
    {
        return $this->hasMany(Surat::class, 'pengirim_id');
    }
    
    public function approval()
    {
        return $this->hasMany(Approval::class, 'approver_id');
    }
    
    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'user_id');
    }
}