<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Desa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Desa::all() as $desa) {
            for ($i = 1; $i <= 3; $i++) {
                $judul = "Kegiatan Desa {$desa->nama} Edisi {$i}";
                Berita::create([
                    'desa_id' => $desa->id,
                    'judul' => $judul,
                    'slug' => Str::slug($judul),
                    'isi' => "Ini adalah contoh berita dummy untuk Desa {$desa->nama}. "
                           . "Isi berita dapat diganti oleh admin melalui panel admin. "
                           . "Berita ini dibuat untuk keperluan demo aplikasi.",
                    'tanggal_tayang' => now()->subDays($i),
                ]);
            }
        }
    }
}