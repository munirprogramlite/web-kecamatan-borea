<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Umkm;

class UmkmController extends Controller
{
    public function index(string $desa)
    {
        $desa = Desa::where('slug', $desa)->firstOrFail();

        $umkm = Umkm::where('desa_id', $desa->id)
            ->where('status', 'tayang')
            ->orderBy('nama')
            ->get();

        return view('desa.umkm.index', compact('desa', 'umkm'));
    }

    public function show(string $desa, string $slug)
    {
        $desa = Desa::where('slug', $desa)->firstOrFail();

        $umkm = Umkm::where('desa_id', $desa->id)
            ->where('slug', $slug)
            ->where('status', 'tayang')
            ->firstOrFail();

        $komentar = \App\Models\Komentar::with('user')
            ->where('target_tipe', 'umkm')
            ->where('target_id', $umkm->id)
            ->orderByDesc('dibuat_pada')
            ->get();

        return view('desa.umkm.detail', compact('desa', 'umkm', 'komentar'));
    }
}