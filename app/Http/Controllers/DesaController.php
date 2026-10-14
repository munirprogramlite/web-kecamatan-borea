<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Berita;
use App\Models\LaporanKeuangan;
use App\Models\Umkm;
use App\Models\WargaAgregat;
use App\Models\Wisata;

class DesaController extends Controller
{
    private function getDesa(string $slug): Desa
    {
        return Desa::where('slug', $slug)->firstOrFail();
    }

    // Beranda desa
    public function show(string $desa)
    {
        $desa = $this->getDesa($desa);

        $jumlahWarga = WargaAgregat::where('desa_id', $desa->id)
            ->selectRaw('SUM(jumlah_laki + jumlah_perempuan) as total')
            ->value('total') ?? 0;

        $jumlahUmkm   = Umkm::where('desa_id', $desa->id)->where('status', 'tayang')->count();
        $jumlahWisata = Wisata::where('desa_id', $desa->id)->where('status', 'tayang')->count();

        $beritaTerbaru = Berita::where('desa_id', $desa->id)
            ->orderByDesc('tanggal_tayang')
            ->limit(3)
            ->get();

        return view('desa.beranda', compact(
            'desa', 'jumlahWarga', 'jumlahUmkm', 'jumlahWisata', 'beritaTerbaru'
        ));
    }

    // Profil desa + statistik warga
    public function profil(string $desa)
{
    $desa = $this->getDesa($desa);

    $warga = WargaAgregat::where('desa_id', $desa->id)
        ->orderByDesc('periode')
        ->first();

    // Ringkasan keuangan (Opsi C)
    $laporanDesa = LaporanKeuangan::where('desa_id', $desa->id)
        ->where('status', 'dipublikasikan')
        ->orderBy('periode')
        ->get();

    $ringkasanKeuangan = null;
    if ($laporanDesa->count() > 0) {
        $ringkasanKeuangan = [
            'total_pemasukan'   => $laporanDesa->sum('pemasukan'),
            'total_pengeluaran' => $laporanDesa->sum('pengeluaran'),
            'saldo_terakhir'    => $laporanDesa->last()->saldo,
            'jumlah_periode'    => $laporanDesa->count(),
        ];
    }

    return view('desa.profil', compact('desa', 'warga', 'ringkasanKeuangan'));
}

    // Kontak
    public function kontak(string $desa)
    {
        $desa = $this->getDesa($desa);
        return view('desa.kontak', compact('desa'));
    }

    // Laporan keuangan
    public function laporan(string $desa)
    {
        $desa = $this->getDesa($desa);

        $laporan = LaporanKeuangan::where('desa_id', $desa->id)
            ->where('status', 'dipublikasikan')
            ->orderBy('periode')
            ->get();

        return view('desa.laporan', compact('desa', 'laporan'));
    }

    // Daftar berita
    public function berita(string $desa)
    {
        $desa = $this->getDesa($desa);
        $berita = Berita::where('desa_id', $desa->id)
            ->orderByDesc('tanggal_tayang')
            ->get();

        return view('desa.berita.index', compact('desa', 'berita'));
    }

    // Detail berita
    public function beritaDetail(string $desa, string $slug)
    {
        $desa = $this->getDesa($desa);
        $berita = Berita::where('desa_id', $desa->id)
            ->where('slug', $slug)
            ->firstOrFail();

        return view('desa.berita.detail', compact('desa', 'berita'));
    }
}