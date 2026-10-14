<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\WargaAgregat;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    private function cekAkses(WargaAgregat $warga): void
    {
        $user = auth()->user();
        if ($user->desa_id !== null && $user->desa_id !== $warga->desa_id) {
            abort(403, 'Kamu hanya bisa mengelola data warga desa sendiri.');
        }
    }

    public function index()
    {
        $user = auth()->user();
        $q = WargaAgregat::with('desa')->orderBy('periode', 'desc');

        if ($user->desa_id !== null) {
            $q->where('desa_id', $user->desa_id);
        }

        $warga = $q->paginate(15);

        return view('admin.warga.index', compact('warga'));
    }

    public function create()
    {
        $desa = $this->desaUntukForm();
        return view('admin.warga.create', compact('desa'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'desa_id'          => 'required|exists:desa,id',
            'periode'          => 'required|string|max:20',
            'jumlah_kk'        => 'required|integer|min:0',
            'jumlah_laki'      => 'required|integer|min:0',
            'jumlah_perempuan' => 'required|integer|min:0',
            'usia_0_14'        => 'required|integer|min:0',
            'usia_15_64'       => 'required|integer|min:0',
            'usia_65_plus'     => 'required|integer|min:0',
        ]);

        $user = auth()->user();
        if ($user->desa_id !== null) {
            $data['desa_id'] = $user->desa_id;
        }

        WargaAgregat::create($data);

        return redirect()->route('admin.warga.index')->with('sukses', 'Data warga berhasil disimpan.');
    }

    public function edit(WargaAgregat $warga)
    {
        $this->cekAkses($warga);
        $desa = $this->desaUntukForm();
        return view('admin.warga.edit', compact('warga', 'desa'));
    }

    public function update(Request $request, WargaAgregat $warga)
    {
        $this->cekAkses($warga);

        $data = $request->validate([
            'desa_id'          => 'required|exists:desa,id',
            'periode'          => 'required|string|max:20',
            'jumlah_kk'        => 'required|integer|min:0',
            'jumlah_laki'      => 'required|integer|min:0',
            'jumlah_perempuan' => 'required|integer|min:0',
            'usia_0_14'        => 'required|integer|min:0',
            'usia_15_64'       => 'required|integer|min:0',
            'usia_65_plus'     => 'required|integer|min:0',
        ]);

        $user = auth()->user();
        if ($user->desa_id !== null) {
            $data['desa_id'] = $user->desa_id;
        }

        $warga->update($data);

        return redirect()->route('admin.warga.index')->with('sukses', 'Data warga berhasil diperbarui.');
    }

    public function destroy(WargaAgregat $warga)
    {
        $this->cekAkses($warga);
        $warga->delete();
        return back()->with('sukses', 'Data warga dihapus.');
    }

    private function desaUntukForm()
    {
        $user = auth()->user();
        if ($user->desa_id !== null) {
            return Desa::where('id', $user->desa_id)->get();
        }
        return Desa::orderBy('nama')->get();
    }
}