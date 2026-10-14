<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $table = 'desa';
    protected $fillable = [
        'kecamatan_id', 'nama', 'slug', 'sambutan', 'sejarah',
        'letak_geografis', 'telepon', 'alamat_balai', 'jam_layanan',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function umkm()
    {
        return $this->hasMany(Umkm::class);
    }

    public function wisata()
    {
        return $this->hasMany(Wisata::class);
    }

    public function berita()
    {
        return $this->hasMany(Berita::class);
    }

    public function laporan()
    {
        return $this->hasMany(LaporanKeuangan::class);
    }

    public function wargaAgregat()
    {
        return $this->hasMany(WargaAgregat::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}