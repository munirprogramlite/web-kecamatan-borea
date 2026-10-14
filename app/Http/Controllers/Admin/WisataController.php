<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WisataController extends Controller
{
    private function cekAkses(Wisata $wisata): void
    {
        $user = auth()->user();
        if ($user->desa_id !== null && $user->desa_id !== $wisata->desa_id) {
            abort(403, 'Kamu hanya bisa mengelola wisata desa sendiri.');
        }
    }

    public function index(Request $request)
    {
        $user = auth()->user();

        $q = Wisata::with('desa')->orderByDesc('id');

        if ($user->desa_id !== null) {
            $q->where('desa_id', $user->desa_id);
        }

        if ($request->filled('cari')) {
            $q->where('nama', 'like', '%' . $request->cari . '%');
        }

        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }

        $wisata = $q->paginate(10)->withQueryString();

        return view('admin.wisata.index', compact('wisata'));
    }

    public function create()
    {
        $desa = $this->desaUntukForm();
        return view('admin.wisata.create', compact('desa'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'desa_id'     => 'required|exists:desa,id',
            'nama'        => 'required|string|max:150',
            'foto'        => 'nullable|image|max:2048',
            'deskripsi'   => 'nullable|string',
            'harga_tiket' => 'nullable|string|max:50',
            'jam_buka'    => 'nullable|string|max:100',
            'alamat'      => 'nullable|string',
            'kontak'      => 'nullable|string|max:30',
            'status'      => 'required|in:tayang,nonaktif',
        ]);

        $user = auth()->user();
        if ($user->desa_id !== null) {
            $data['desa_id'] = $user->desa_id;
        }

        $data['slug'] = $this->slugUnik($data['nama']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('wisata', 'public');
        }

        Wisata::create($data);

        return redirect()->route('admin.wisata.index')->with('sukses', 'Wisata berhasil ditambahkan.');
    }

    public function edit(Wisata $wisata)
    {
        $this->cekAkses($wisata);
        $desa = $this->desaUntukForm();
        return view('admin.wisata.edit', compact('wisata', 'desa'));
    }

    public function update(Request $request, Wisata $wisata)
    {
        $this->cekAkses($wisata);

        $data = $request->validate([
            'desa_id'     => 'required|exists:desa,id',
            'nama'        => 'required|string|max:150',
            'foto'        => 'nullable|image|max:2048',
            'deskripsi'   => 'nullable|string',
            'harga_tiket' => 'nullable|string|max:50',
            'jam_buka'    => 'nullable|string|max:100',
            'alamat'      => 'nullable|string',
            'kontak'      => 'nullable|string|max:30',
            'status'      => 'required|in:tayang,nonaktif',
        ]);

        $user = auth()->user();
        if ($user->desa_id !== null) {
            $data['desa_id'] = $user->desa_id;
        }

        if ($wisata->nama !== $data['nama']) {
            $data['slug'] = $this->slugUnik($data['nama'], $wisata->id);
        }

        if ($request->hasFile('foto')) {
            if ($wisata->foto) Storage::disk('public')->delete($wisata->foto);
            $data['foto'] = $request->file('foto')->store('wisata', 'public');
        }

        $wisata->update($data);

        return redirect()->route('admin.wisata.index')->with('sukses', 'Wisata berhasil diperbarui.');
    }

    public function toggle(Wisata $wisata)
    {
        $this->cekAkses($wisata);
        $wisata->update([
            'status' => $wisata->status === 'tayang' ? 'nonaktif' : 'tayang',
        ]);

        return back()->with('sukses', 'Status wisata diubah menjadi ' . $wisata->status . '.');
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
        while (Wisata::where('slug', $slug)->when($kecualiId, fn ($q) => $q->where('id', '!=', $kecualiId))->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}