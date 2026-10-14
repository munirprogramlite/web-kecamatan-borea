<?php

namespace Database\Seeders;

use App\Models\Desa;
use App\Models\LaporanKeuangan;
use Illuminate\Database\Seeder;

class LaporanKeuanganSeeder extends Seeder
{
    public function run(): void
    {
        $periodeList = [
            '2026-07', '2026-08', '2026-09', '2026-10',
        ];

        foreach (Desa::all() as $desa) {
            foreach ($periodeList as $periode) {
                $pemasukan = rand(5_000_000, 20_000_000);
                $pengeluaran = rand(3_000_000, $pemasukan);
                LaporanKeuangan::create([
                    'desa_id' => $desa->id,
                    'periode' => $periode,
                    'pemasukan' => $pemasukan,
                    'pengeluaran' => $pengeluaran,
                    'saldo' => $pemasukan - $pengeluaran,
                    'status' => 'dipublikasikan',
                ]);
            }
        }
    }
}