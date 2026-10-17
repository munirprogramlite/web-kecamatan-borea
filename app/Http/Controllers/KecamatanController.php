<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Umkm;
use App\Models\WargaAgregat;
use App\Models\Wisata;

class KecamatanController extends Controller
{
    public function index()
    {
        $kecamatan = Kecamatan::first();

        $totalPenduduk = WargaAgregat::sum('jumlah_laki') + WargaAgregat::sum('jumlah_perempuan');
        $totalKK       = WargaAgregat::sum('jumlah_kk');
        $totalUmkm     = Umkm::where('status', 'tayang')->count();
        $totalWisata   = Wisata::where('status', 'tayang')->count();

        $desaList = Desa::orderBy('nama')->get();   // ← Urut A-Z

        // Ambil 10 berita terbaru (untuk slider)
        $beritaTerbaru = Berita::with('desa')
            ->orderByDesc('tanggal_tayang')
            ->limit(10)
            ->get();

        return view('kecamatan.index', compact(
            'kecamatan', 'totalPenduduk', 'totalKK',
            'totalUmkm', 'totalWisata', 'desaList', 'beritaTerbaru'
        ));
    }
}