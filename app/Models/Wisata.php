<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    protected $table = 'wisata';
    protected $fillable = [
        'desa_id', 'nama', 'slug', 'foto', 'deskripsi',
        'harga_tiket', 'jam_buka', 'alamat', 'kontak', 'status',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class, 'target_id')
                    ->where('target_tipe', 'wisata');
    }
}