@extends('layouts.admin')

@section('title', 'Data Warga')

@section('content')

<div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
    <h1 class="text-2xl font-poppins font-bold text-hijau-daun">Data Warga (Agregat)</h1>
    <a href="{{ route('admin.warga.create') }}"
       class="inline-block bg-hijau-daun text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-hijau-daun/90">
        + Tambah Data
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead class="bg-hijau-daun text-white">
            <tr>
                <th class="px-4 py-3 text-left">Periode</th>
                <th class="px-4 py-3 text-left">Desa</th>
                <th class="px-4 py-3 text-right">KK</th>
                <th class="px-4 py-3 text-right">L</th>
                <th class="px-4 py-3 text-right">P</th>
                <th class="px-4 py-3 text-right">0-14</th>
                <th class="px-4 py-3 text-right">15-64</th>
                <th class="px-4 py-3 text-right">65+</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse ($warga as $w)
                <tr>
                    <td class="px-4 py-3 font-semibold">{{ $w->periode }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $w->desa->nama ?? '-' }}</td>
                    <td class="px-4 py-3 text-right">{{ number_format($w->jumlah_kk) }}</td>
                    <td class="px-4 py-3 text-right">{{ number_format($w->jumlah_laki) }}</td>
                    <td class="px-4 py-3 text-right">{{ number_format($w->jumlah_perempuan) }}</td>
                    <td class="px-4 py-3 text-right">{{ number_format($w->usia_0_14) }}</td>
                    <td class="px-4 py-3 text-right">{{ number_format($w->usia_15_64) }}</td>
                    <td class="px-4 py-3 text-right">{{ number_format($w->usia_65_plus) }}</td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <a href="{{ route('admin.warga.edit', $w) }}"
                           class="text-hijau-daun text-xs font-semibold hover:underline">Edit</a>
                        <form action="{{ route('admin.warga.destroy', $w) }}" method="POST" class="inline ml-3"
                              onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="px-4 py-8 text-center text-gray-500">Belum ada data warga.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $warga->links() }}</div>

@endsection