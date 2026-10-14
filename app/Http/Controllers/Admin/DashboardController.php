<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Komentar;
use App\Models\Umkm;
use App\Models\Wisata;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $desaId = $user->desa_id; // null = admin kecamatan

        // Query dasar: kalau admin desa, filter desa_id. Kalau admin kecamatan, semua.
        $umkmQ   = Umkm::query();
        $wisataQ = Wisata::query();
        $beritaQ = Berita::query();

        if ($desaId !== null) {
            $umkmQ->where('desa_id', $desaId);
            $wisataQ->where('desa_id', $desaId);
            $beritaQ->where('desa_id', $desaId);
        }

        $totalUmkm   = (clone $umkmQ)->count();
        $totalWisata = (clone $wisataQ)->count();
        $totalBerita = (clone $beritaQ)->count();

        // Komentar terbaru (dibatasi sesuai desa kalau admin desa)
        $komentarQ = Komentar::with('user')->orderByDesc('dibuat_pada');

        if ($desaId !== null) {
            // Filter komentar berdasarkan target: umkm/wisata milik desa ini
            $umkmIds   = Umkm::where('desa_id', $desaId)->pluck('id');
            $wisataIds = Wisata::where('desa_id', $desaId)->pluck('id');

            $komentarQ->where(function ($q) use ($umkmIds, $wisataIds) {
                $q->where(function ($q2) use ($umkmIds) {
                    $q2->where('target_tipe', 'umkm')->whereIn('target_id', $umkmIds);
                })->orWhere(function ($q2) use ($wisataIds) {
                    $q2->where('target_tipe', 'wisata')->whereIn('target_id', $wisataIds);
                });
            });
        }

        $komentarTerbaru = $komentarQ->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalUmkm', 'totalWisata', 'totalBerita', 'komentarTerbaru'
        ));
    }
}