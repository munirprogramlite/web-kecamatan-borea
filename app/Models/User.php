<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'nama_akun', 'email', 'password', 'peran', 'desa_id',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class);
    }

    public function isAdmin(): bool
    {
        return $this->peran === 'admin';
    }
}