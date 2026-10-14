<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Komentar;
use App\Models\Umkm;
use App\Models\Wisata;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $q = Komentar::with('user')->orderByDesc('dibuat_pada');

        // Filter desa untuk admin desa
        if ($user->desa_id !== null) {
            $umkmIds   = Umkm::where('desa_id', $user->desa_id)->pluck('id');
            $wisataIds = Wisata::where('desa_id', $user->desa_id)->pluck('id');

            $q->where(function ($q) use ($umkmIds, $wisataIds) {
                $q->where(function ($q2) use ($umkmIds) {
                    $q2->where('target_tipe', 'umkm')->whereIn('target_id', $umkmIds);
                })->orWhere(function ($q2) use ($wisataIds) {
                    $q2->where('target_tipe', 'wisata')->whereIn('target_id', $wisataIds);
                });
            });
        }

        if ($request->filled('tipe')) {
            $q->where('target_tipe', $request->tipe);
        }

        $komentar = $q->paginate(20)->withQueryString();

        return view('admin.komentar.index', compact('komentar'));
    }

    public function destroy(Komentar $komentar)
    {
        $user = auth()->user();

        // Kalau admin desa, cek target benar-benar milik desanya
        if ($user->desa_id !== null) {
            $desaTarget = null;
            if ($komentar->target_tipe === 'umkm') {
                $desaTarget = Umkm::find($komentar->target_id)?->desa_id;
            } else {
                $desaTarget = Wisata::find($komentar->target_id)?->desa_id;
            }

            if ($desaTarget !== $user->desa_id) {
                abort(403, 'Kamu hanya bisa memoderasi komentar di desa sendiri.');
            }
        }

        $komentar->delete();

        return back()->with('sukses', 'Komentar berhasil dihapus.');
    }
}