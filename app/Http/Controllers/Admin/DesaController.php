<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DesaController extends Controller
{
    private function pastikanAdminKecamatan(): void
    {
        if (auth()->user()->desa_id !== null) {
            abort(403, 'Hanya admin kecamatan yang bisa mengelola desa.');
        }
    }

    public function index()
    {
        $this->pastikanAdminKecamatan();
        $desa = Desa::orderBy('nama')->paginate(10);
        return view('admin.desa.index', compact('desa'));
    }

    public function create()
    {
        $this->pastikanAdminKecamatan();
        return view('admin.desa.create');
    }

    public function store(Request $request)
    {
        $this->pastikanAdminKecamatan();

        $data = $request->validate([
            'nama'             => 'required|string|max:100',
            'sambutan'         => 'nullable|string',
            'sejarah'          => 'nullable|string',
            'letak_geografis'  => 'nullable|string',
            'telepon'          => 'nullable|string|max:30',
            'alamat_balai'     => 'nullable|string',
            'jam_layanan'      => 'nullable|string|max:100',
        ]);

        $data['slug'] = $this->slugUnik($data['nama']);
        $data['kecamatan_id'] = Kecamatan::first()->id;

        Desa::create($data);

        return redirect()->route('admin.desa.index')->with('sukses', 'Desa baru berhasil ditambahkan.');
    }

    public function edit(Desa $desa)
    {
        $this->pastikanAdminKecamatan();
        return view('admin.desa.edit', compact('desa'));
    }

    public function update(Request $request, Desa $desa)
    {
        $this->pastikanAdminKecamatan();

        $data = $request->validate([
            'nama'             => 'required|string|max:100',
            'sambutan'         => 'nullable|string',
            'sejarah'          => 'nullable|string',
            'letak_geografis'  => 'nullable|string',
            'telepon'          => 'nullable|string|max:30',
            'alamat_balai'     => 'nullable|string',
            'jam_layanan'      => 'nullable|string|max:100',
        ]);

        if ($desa->nama !== $data['nama']) {
            $data['slug'] = $this->slugUnik($data['nama'], $desa->id);
        }

        $desa->update($data);

        return redirect()->route('admin.desa.index')->with('sukses', 'Desa berhasil diperbarui.');
    }

    public function destroy(Desa $desa)
    {
        $this->pastikanAdminKecamatan();

        // Cek: apakah desa masih punya data terkait?
        $punyaData = $desa->umkm()->exists()
            || $desa->wisata()->exists()
            || $desa->berita()->exists()
            || $desa->laporan()->exists()
            || $desa->wargaAgregat()->exists();

        if ($punyaData) {
            return back()->with('error',
                'Tidak bisa hapus Desa ' . $desa->nama . ' karena masih memiliki data (UMKM, Wisata, Berita, dll). Hapus datanya terlebih dahulu.');
        }

        $desa->delete();

        return redirect()->route('admin.desa.index')->with('sukses', 'Desa berhasil dihapus.');
    }

    private function slugUnik(string $nama, ?int $kecualiId = null): string
    {
        $slug = Str::slug($nama);
        $base = $slug;
        $i = 2;
        while (Desa::where('slug', $slug)->when($kecualiId, fn ($q) => $q->where('id', '!=', $kecualiId))->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}