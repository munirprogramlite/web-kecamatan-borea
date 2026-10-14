<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Wisata;

class WisataController extends Controller
{
    public function index(string $desa)
    {
        $desa = Desa::where('slug', $desa)->firstOrFail();

        $wisata = Wisata::where('desa_id', $desa->id)
            ->where('status', 'tayang')
            ->orderBy('nama')
            ->get();

        return view('desa.wisata.index', compact('desa', 'wisata'));
    }

    public function show(string $desa, string $slug)
    {
        $desa = Desa::where('slug', $desa)->firstOrFail();

        $wisata = Wisata::where('desa_id', $desa->id)
            ->where('slug', $slug)
            ->where('status', 'tayang')
            ->firstOrFail();

        $komentar = \App\Models\Komentar::with('user')
            ->where('target_tipe', 'wisata')
            ->where('target_id', $wisata->id)
            ->orderByDesc('dibuat_pada')
            ->get();

        return view('desa.wisata.detail', compact('desa', 'wisata', 'komentar'));
    }
}