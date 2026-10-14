<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UmkmController extends Controller
{
    private function cekAkses(Umkm $umkm): void
    {
        $user = auth()->user();
        if ($user->desa_id !== null && $user->desa_id !== $umkm->desa_id) {
            abort(403, 'Kamu hanya bisa mengelola UMKM desa sendiri.');
        }
    }

    public function index(Request $request)
    {
        $user = auth()->user();

        $q = Umkm::with('desa')->orderByDesc('id');

        if ($user->desa_id !== null) {
            $q->where('desa_id', $user->desa_id);
        }

        if ($request->filled('cari')) {
            $q->where('nama', 'like', '%' . $request->cari . '%');
        }

        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }

        $umkm = $q->paginate(10)->withQueryString();

        return view('admin.umkm.index', compact('umkm'));
    }

    public function create()
    {
        $desa = $this->desaUntukForm();
        return view('admin.umkm.create', compact('desa'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'desa_id'   => 'required|exists:desa,id',
            'nama'      => 'required|string|max:150',
            'foto'      => 'nullable|image|max:2048',
            'deskripsi' => 'nullable|string',
            'menu'      => 'nullable|string',
            'alamat'    => 'nullable|string',
            'kontak'    => 'nullable|string|max:30',
            'status'    => 'required|in:tayang,nonaktif',
        ]);

        // Admin desa: paksa desa_id sesuai desanya
        $user = auth()->user();
        if ($user->desa_id !== null) {
            $data['desa_id'] = $user->desa_id;
        }

        // Slug dari nama, pastikan unik
        $data['slug'] = $this->slugUnik($data['nama']);

        // Upload foto
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('umkm', 'public');
        }

        Umkm::create($data);

        return redirect()->route('admin.umkm.index')->with('sukses', 'UMKM berhasil ditambahkan.');
    }

    public function edit(Umkm $umkm)
    {
        $this->cekAkses($umkm);
        $desa = $this->desaUntukForm();
        return view('admin.umkm.edit', compact('umkm', 'desa'));
    }

    public function update(Request $request, Umkm $umkm)
    {
        $this->cekAkses($umkm);

        $data = $request->validate([
            'desa_id'   => 'required|exists:desa,id',
            'nama'      => 'required|string|max:150',
            'foto'      => 'nullable|image|max:2048',
            'deskripsi' => 'nullable|string',
            'menu'      => 'nullable|string',
            'alamat'    => 'nullable|string',
            'kontak'    => 'nullable|string|max:30',
            'status'    => 'required|in:tayang,nonaktif',
        ]);

        $user = auth()->user();
        if ($user->desa_id !== null) {
            $data['desa_id'] = $user->desa_id;
        }

        if ($umkm->nama !== $data['nama']) {
            $data['slug'] = $this->slugUnik($data['nama'], $umkm->id);
        }

        if ($request->hasFile('foto')) {
            if ($umkm->foto) Storage::disk('public')->delete($umkm->foto);
            $data['foto'] = $request->file('foto')->store('umkm', 'public');
        }

        $umkm->update($data);

        return redirect()->route('admin.umkm.index')->with('sukses', 'UMKM berhasil diperbarui.');
    }

    public function toggle(Umkm $umkm)
    {
        $this->cekAkses($umkm);
        $umkm->update([
            'status' => $umkm->status === 'tayang' ? 'nonaktif' : 'tayang',
        ]);

        return back()->with('sukses', 'Status UMKM diubah menjadi ' . $umkm->status . '.');
    }

    private function desaUntukForm()
    {
        $user = auth()->user();
        if ($user->desa_id !== null) {
            return Desa::where('id', $user->desa_id)->get();
        }
        return Desa::orderBy('nama')->get();
    }

    private function slugUnik(string $nama, ?int $kecualiId = null): string
    {
        $slug = Str::slug($nama);
        $base = $slug;
        $i = 2;
        while (Umkm::where('slug', $slug)->when($kecualiId, fn ($q) => $q->where('id', '!=', $kecualiId))->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}