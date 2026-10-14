<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\LaporanKeuangan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    private function cekAkses(LaporanKeuangan $laporan): void
    {
        $user = auth()->user();
        if ($user->desa_id !== null && $user->desa_id !== $laporan->desa_id) {
            abort(403, 'Kamu hanya bisa mengelola laporan desa sendiri.');
        }
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $q = LaporanKeuangan::with('desa')->orderBy('periode', 'desc');

        if ($user->desa_id !== null) {
            $q->where('desa_id', $user->desa_id);
        }

        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }

        $laporan = $q->paginate(15)->withQueryString();

        return view('admin.laporan.index', compact('laporan'));
    }

    public function create()
    {
        $desa = $this->desaUntukForm();
        return view('admin.laporan.create', compact('desa'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'desa_id'      => 'required|exists:desa,id',
            'periode'      => 'required|string|max:20',
            'pemasukan'    => 'required|numeric|min:0',
            'pengeluaran'  => 'required|numeric|min:0',
            'status'       => 'required|in:draf,dipublikasikan',
        ]);

        $user = auth()->user();
        if ($user->desa_id !== null) {
            $data['desa_id'] = $user->desa_id;
        }

        $data['saldo'] = $data['pemasukan'] - $data['pengeluaran'];

        LaporanKeuangan::create($data);

        return redirect()->route('admin.laporan.index')->with('sukses', 'Laporan berhasil ditambahkan.');
    }

    public function edit(LaporanKeuangan $laporan)
    {
        $this->cekAkses($laporan);
        $desa = $this->desaUntukForm();
        return view('admin.laporan.edit', compact('laporan', 'desa'));
    }

    public function update(Request $request, LaporanKeuangan $laporan)
    {
        $this->cekAkses($laporan);

        $data = $request->validate([
            'desa_id'      => 'required|exists:desa,id',
            'periode'      => 'required|string|max:20',
            'pemasukan'    => 'required|numeric|min:0',
            'pengeluaran'  => 'required|numeric|min:0',
            'status'       => 'required|in:draf,dipublikasikan',
        ]);

        $user = auth()->user();
        if ($user->desa_id !== null) {
            $data['desa_id'] = $user->desa_id;
        }

        $data['saldo'] = $data['pemasukan'] - $data['pengeluaran'];

        $laporan->update($data);

        return redirect()->route('admin.laporan.index')->with('sukses', 'Laporan berhasil diperbarui.');
    }

    public function destroy(LaporanKeuangan $laporan)
    {
        $this->cekAkses($laporan);
        $laporan->delete();
        return back()->with('sukses', 'Laporan dihapus.');
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