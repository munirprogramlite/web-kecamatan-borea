<?php

namespace Database\Seeders;

use App\Models\Desa;
use App\Models\Umkm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UmkmSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'hainan'  => ['nama' => 'Soto Bu Rosa',            'menu' => "Soto Ayam - Rp 15.000\nSoto Daging - Rp 20.000\nEs Teh - Rp 5.000"],
            'joreu'   => ['nama' => 'Batik Tenun Pak Bambang', 'menu' => "Kain Batik - Rp 150.000\nSelendang - Rp 75.000\nSyal - Rp 50.000"],
            'kartula' => ['nama' => 'Payung Tradisional Mas Reza', 'menu' => "Payung Kertas - Rp 60.000\nPayung Lukis - Rp 120.000"],
        ];

        foreach ($data as $slug => $item) {
            $desa = Desa::where('slug', $slug)->first();
            Umkm::create([
                'desa_id' => $desa->id,
                'nama' => $item['nama'],
                'slug' => Str::slug($item['nama']),
                'foto' => null,
                'deskripsi' => 'UMKM unggulan Desa ' . $desa->nama . ' yang menyajikan produk berkualitas.',
                'menu' => $item['menu'],
                'alamat' => 'Jl. Raya ' . $desa->nama . ', Kecamatan Borea',
                'kontak' => '0812-0000-' . rand(1000, 9999),
                'status' => 'tayang',
            ]);
        }
    }
}