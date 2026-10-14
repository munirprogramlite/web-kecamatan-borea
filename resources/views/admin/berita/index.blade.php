@extends('layouts.admin')

@section('title', 'Kelola Berita')

@section('content')

<div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
    <h1 class="text-2xl font-poppins font-bold text-hijau-daun">Kelola Berita</h1>
    <a href="{{ route('admin.berita.create') }}"
       class="inline-block bg-hijau-daun text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-hijau-daun/90">
        + Tambah Berita
    </a>
</div>

<form method="GET" class="bg-white rounded-xl shadow p-4 mb-4 flex gap-3 text-sm">
    <input type="text" name="cari" value="{{ request('cari') }}"
           placeholder="Cari judul berita..."
           class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
    <button type="submit"
            class="bg-cokelat-tanah text-white px-4 py-2 rounded-lg font-semibold hover:bg-cokelat-tanah/90">
        Cari
    </button>
</form>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-hijau-daun text-white">
            <tr>
                <th class="px-4 py-3 text-left">Judul</th>
                <th class="px-4 py-3 text-left">Desa</th>
                <th class="px-4 py-3 text-left">Tanggal</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse ($berita as $b)
                <tr>
                    <td class="px-4 py-3 font-semibold">{{ $b->judul }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $b->desa->nama ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $b->tanggal_tayang->translatedFormat('d F Y') }}</td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <a href="{{ url('/borea/' . $b->desa->slug . '/berita/' . $b->slug) }}"
                           target="_blank"
                           class="text-xs text-gray-500 hover:underline">Lihat</a>
                        <a href="{{ route('admin.berita.edit', $b) }}"
                           class="text-hijau-daun text-xs font-semibold hover:underline ml-3">Edit</a>
                        <form action="{{ route('admin.berita.destroy', $b) }}" method="POST" class="inline ml-3"
                              onsubmit="return confirm('Yakin hapus berita ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-8 text-center text-gray-500">Belum ada berita.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $berita->links() }}</div>

@endsection