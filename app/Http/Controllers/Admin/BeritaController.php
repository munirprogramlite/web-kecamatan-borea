<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    private function cekAkses(Berita $berita): void
    {
        $user = auth()->user();
        if ($user->desa_id !== null && $user->desa_id !== $berita->desa_id) {
            abort(403, 'Kamu hanya bisa mengelola berita desa sendiri.');
        }
    }

    public function index(Request $request)
    {
        $user = auth()->user();

        $q = Berita::with('desa')->orderByDesc('tanggal_tayang')->orderByDesc('id');

        if ($user->desa_id !== null) {
            $q->where('desa_id', $user->desa_id);
        }

        if ($request->filled('cari')) {
            $q->where('judul', 'like', '%' . $request->cari . '%');
        }

        $berita = $q->paginate(10)->withQueryString();

        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        $desa = $this->desaUntukForm();
        return view('admin.berita.create', compact('desa'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'desa_id'        => 'required|exists:desa,id',
            'judul'          => 'required|string|max:200',
            'isi'            => 'required|string',
            'tanggal_tayang' => 'required|date',
        ]);

        $user = auth()->user();
        if ($user->desa_id !== null) {
            $data['desa_id'] = $user->desa_id;
        }

        $data['slug'] = $this->slugUnik($data['judul']);

        Berita::create($data);

        return redirect()->route('admin.berita.index')->with('sukses', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $berita)
    {
        $this->cekAkses($berita);
        $desa = $this->desaUntukForm();
        return view('admin.berita.edit', compact('berita', 'desa'));
    }

    public function update(Request $request, Berita $berita)
    {
        $this->cekAkses($berita);

        $data = $request->validate([
            'desa_id'        => 'required|exists:desa,id',
            'judul'          => 'required|string|max:200',
            'isi'            => 'required|string',
            'tanggal_tayang' => 'required|date',
        ]);

        $user = auth()->user();
        if ($user->desa_id !== null) {
            $data['desa_id'] = $user->desa_id;
        }

        if ($berita->judul !== $data['judul']) {
            $data['slug'] = $this->slugUnik($data['judul'], $berita->id);
        }

        $berita->update($data);

        return redirect()->route('admin.berita.index')->with('sukses', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        $this->cekAkses($berita);
        $berita->delete();

        return back()->with('sukses', 'Berita berhasil dihapus.');
    }

    private function desaUntukForm()
    {
        $user = auth()->user();
        if ($user->desa_id !== null) {
            return Desa::where('id', $user->desa_id)->get();
        }
        return Desa::orderBy('nama')->get();
    }

    private function slugUnik(string $judul, ?int $kecualiId = null): string
    {
        $slug = Str::slug($judul);
        $base = $slug;
        $i = 2;
        while (Berita::where('slug', $slug)->when($kecualiId, fn ($q) => $q->where('id', '!=', $kecualiId))->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}