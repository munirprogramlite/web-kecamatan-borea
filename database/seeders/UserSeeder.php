<?php

namespace Database\Seeders;

use App\Models\Desa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin kecamatan (desa_id kosong) — bisa melihat semua desa
        User::create([
            'name' => 'Admin Kecamatan',
            'nama_akun' => 'admin',
            'email' => 'admin@borea.test',
            'password' => Hash::make('password123'),
            'peran' => 'admin',
            'desa_id' => null,
        ]);

        // Admin desa (contoh: Hainan)
        $hainan = Desa::where('slug', 'hainan')->first();
        User::create([
            'name' => 'Admin Hainan',
            'nama_akun' => 'admin_hainan',
            'email' => 'hainan@borea.test',
            'password' => Hash::make('password123'),
            'peran' => 'admin',
            'desa_id' => $hainan->id,
        ]);

        // Warga contoh
        User::create([
            'name' => 'Warga Contoh',
            'nama_akun' => 'warga1',
            'email' => 'warga@borea.test',
            'password' => Hash::make('password123'),
            'peran' => 'warga',
            'desa_id' => $hainan->id,
        ]);
    }
}