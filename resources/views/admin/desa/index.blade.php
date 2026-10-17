@extends('layouts.admin')

@section('title', 'Kelola Desa')

@section('content')

<div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-poppins font-bold text-hijau-daun">Kelola Desa</h1>
        <p class="text-sm text-gray-600 mt-1">Tambah, edit, atau hapus desa di Kecamatan Borea.</p>
    </div>
    <a href="{{ route('admin.desa.create') }}"
       class="inline-block bg-hijau-daun text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-hijau-daun/90">
        + Tambah Desa
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-hijau-daun text-white">
            <tr>
                <th class="px-4 py-3 text-left">Nama Desa</th>
                <th class="px-4 py-3 text-left">Slug</th>
                <th class="px-4 py-3 text-left">Telepon</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse ($desa as $d)
                <tr>
                    <td class="px-4 py-3 font-semibold">{{ $d->nama }}</td>
                    <td class="px-4 py-3 text-gray-500"><code class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $d->slug }}</code></td>
                    <td class="px-4 py-3 text-gray-600">{{ $d->telepon ?? '-' }}</td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <a href="{{ url('/borea/' . $d->slug) }}" target="_blank"
                           class="text-xs text-gray-500 hover:underline">Lihat</a>
                        <a href="{{ route('admin.desa.edit', $d) }}"
                           class="text-hijau-daun text-xs font-semibold hover:underline ml-3">Edit</a>
                        <form action="{{ route('admin.desa.destroy', $d) }}" method="POST" class="inline ml-3"
                              onsubmit="return confirm('Yakin hapus desa {{ $d->nama }}? Data terkait harus dihapus dulu.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-8 text-center text-gray-500">Belum ada desa.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $desa->links() }}</div>

@endsection