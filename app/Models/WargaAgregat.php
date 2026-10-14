<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WargaAgregat extends Model
{
    protected $table = 'warga_agregat';
    protected $fillable = [
        'desa_id', 'periode', 'jumlah_kk', 'jumlah_laki', 'jumlah_perempuan',
        'usia_0_14', 'usia_15_64', 'usia_65_plus',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}