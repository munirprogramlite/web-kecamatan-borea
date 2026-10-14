<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKeuangan extends Model
{
    protected $table = 'laporan_keuangan';
    protected $fillable = [
        'desa_id', 'periode', 'pemasukan', 'pengeluaran', 'saldo', 'status',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}