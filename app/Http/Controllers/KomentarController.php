<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\Umkm;
use App\Models\Wisata;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'target_tipe' => 'required|in:umkm,wisata',
            'target_id'   => 'required|integer',
            'isi'         => 'required|string|max:500',
        ]);

        // Pastikan target benar-benar ada
        if ($request->target_tipe === 'umkm') {
            Umkm::findOrFail($request->target_id);
        } else {
            Wisata::findOrFail($request->target_id);
        }

        Komentar::create([
            'user_id'     => auth()->id(),
            'target_tipe' => $request->target_tipe,
            'target_id'   => $request->target_id,
            'isi'         => $request->isi,
            'dibuat_pada' => now(),
        ]);

        return back()->with('sukses', 'Komentar berhasil dikirim.');
    }

    public function destroy(Komentar $komentar)
    {
        $user = auth()->user();

        // Boleh hapus kalau: pemilik komentar, ATAU admin (kecamatan / desa yang sama)
        $pemilik  = $komentar->user_id === $user->id;
        $adminDesa = $user->peran === 'admin'
            && ($user->desa_id === null || $user->desa_id === $this->desaIdDariTarget($komentar));

        if (! $pemilik && ! $adminDesa) {
            abort(403, 'Kamu tidak boleh menghapus komentar ini.');
        }

        $komentar->delete();
        return back()->with('sukses', 'Komentar dihapus.');
    }

    private function desaIdDariTarget(Komentar $komentar): ?int
    {
        if ($komentar->target_tipe === 'umkm') {
            return Umkm::find($komentar->target_id)?->desa_id;
        }
        return Wisata::find($komentar->target_id)?->desa_id;
    }
}