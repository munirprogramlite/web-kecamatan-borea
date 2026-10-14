<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    protected $table = 'umkm';
    protected $fillable = [
        'desa_id', 'nama', 'slug', 'foto', 'deskripsi',
        'menu', 'alamat', 'kontak', 'status',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class, 'target_id')
                    ->where('target_tipe', 'umkm');
    }
}