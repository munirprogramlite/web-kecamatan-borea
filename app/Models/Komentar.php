<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $table = 'komentar';
    protected $fillable = ['user_id', 'target_tipe', 'target_id', 'isi', 'dibuat_pada'];
    protected $casts = ['dibuat_pada' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}