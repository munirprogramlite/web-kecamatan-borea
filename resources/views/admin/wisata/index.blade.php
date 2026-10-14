@extends('layouts.admin')

@section('title', 'Kelola Wisata')

@section('content')

<div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
    <h1 class="text-2xl font-poppins font-bold text-hijau-daun">Kelola Wisata</h1>
    <a href="{{ route('admin.wisata.create') }}"
       class="inline-block bg-hijau-daun text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-hijau-daun/90">
        + Tambah Wisata
    </a>
</div>

<form method="GET" class="bg-white rounded-xl shadow p-4 mb-4 flex flex-col md:flex-row gap-3 text-sm">
    <input type="text" name="cari" value="{{ request('cari') }}"
           placeholder="Cari nama wisata..."
           class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
    <select name="status"
            class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
        <option value="">Semua Status</option>
        <option value="tayang"   {{ request('status') === 'tayang'   ? 'selected' : '' }}>Tayang</option>
        <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
    </select>
    <button type="submit"
            class="bg-cokelat-tanah text-white px-4 py-2 rounded-lg font-semibold hover:bg-cokelat-tanah/90">
        Cari
    </button>
</form>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-hijau-daun text-white">
            <tr>
                <th class="px-4 py-3 text-left">Foto</th>
                <th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-left">Desa</th>
                <th class="px-4 py-3 text-left">Tiket</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse ($wisata as $w)
                <tr>
                    <td class="px-4 py-3">
                        <div class="w-14 h-14 rounded-lg overflow-hidden bg-hijau-daun/20 flex items-center justify-center text-2xl">
                            @if ($w->foto)
                                <img src="{{ asset('storage/' . $w->foto) }}" class="w-full h-full object-cover" alt="">
                            @else
                                🏞️
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-3 font-semibold">{{ $w->nama }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $w->desa->nama ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $w->harga_tiket ?? 'Gratis' }}</td>
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-1 rounded-full font-semibold
                            {{ $w->status === 'tayang' ? 'bg-hijau-daun/15 text-hijau-daun' : 'bg-gray-200 text-gray-600' }}">
                            {{ ucfirst($w->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <a href="{{ route('admin.wisata.edit', $w) }}"
                           class="text-hijau-daun text-xs font-semibold hover:underline">Edit</a>
                        <form action="{{ route('admin.wisata.toggle', $w) }}" method="POST" class="inline ml-3">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-xs font-semibold
                                {{ $w->status === 'tayang' ? 'text-cokelat-tanah' : 'text-hijau-daun' }} hover:underline">
                                {{ $w->status === 'tayang' ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada data wisata.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $wisata->links() }}</div>

@endsection