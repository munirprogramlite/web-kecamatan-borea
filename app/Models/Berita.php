<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';
    protected $fillable = ['desa_id', 'judul', 'slug', 'isi', 'tanggal_tayang'];
    protected $casts = ['tanggal_tayang' => 'date'];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}