<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            KecamatanSeeder::class,
            DesaSeeder::class,
            UserSeeder::class,
            UmkmSeeder::class,
            WisataSeeder::class,
            BeritaSeeder::class,
            LaporanKeuanganSeeder::class,
            WargaAgregatSeeder::class,
        ]);
    }
}