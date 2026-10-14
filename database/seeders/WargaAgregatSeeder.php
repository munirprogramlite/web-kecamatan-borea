<?php

namespace Database\Seeders;

use App\Models\Desa;
use App\Models\WargaAgregat;
use Illuminate\Database\Seeder;

class WargaAgregatSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Desa::all() as $desa) {
            $laki = rand(500, 1500);
            $perempuan = rand(500, 1500);

            WargaAgregat::create([
                'desa_id' => $desa->id,
                'periode' => '2026',
                'jumlah_kk' => rand(300, 800),
                'jumlah_laki' => $laki,
                'jumlah_perempuan' => $perempuan,
                'usia_0_14' => rand(200, 500),
                'usia_15_64' => rand(600, 1200),
                'usia_65_plus' => rand(50, 200),
            ]);
        }
    }
}