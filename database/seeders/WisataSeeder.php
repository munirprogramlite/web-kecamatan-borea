<?php

namespace Database\Seeders;

use App\Models\Desa;
use App\Models\Wisata;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WisataSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'hainan'  => ['nama' => 'Kolam Renang',    'harga' => 'Rp 10.000', 'jam' => '07.00 - 18.00'],
            'joreu'   => ['nama' => 'Bukit Indah',     'harga' => 'Rp 5.000',  'jam' => '06.00 - 18.00'],
            'kartula' => ['nama' => 'Taman Ilmu',      'harga' => 'Gratis',    'jam' => '08.00 - 17.00'],
        ];

        foreach ($data as $slug => $item) {
            $desa = Desa::where('slug', $slug)->first();
            Wisata::create([
                'desa_id' => $desa->id,
                'nama' => $item['nama'],
                'slug' => Str::slug($item['nama']),
                'foto' => null,
                'deskripsi' => 'Wisata andalan Desa ' . $desa->nama . ' dengan pemandangan yang memukau.',
                'harga_tiket' => $item['harga'],
                'jam_buka' => $item['jam'],
                'alamat' => 'Kawasan Wisata Desa ' . $desa->nama,
                'kontak' => '0812-1111-' . rand(1000, 9999),
                'status' => 'tayang',
            ]);
        }
    }
}