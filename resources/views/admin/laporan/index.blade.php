@extends('layouts.admin')

@section('title', 'Kelola Laporan Keuangan')

@section('content')

<div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
    <h1 class="text-2xl font-poppins font-bold text-hijau-daun">Kelola Laporan Keuangan</h1>
    <a href="{{ route('admin.laporan.create') }}"
       class="inline-block bg-hijau-daun text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-hijau-daun/90">
        + Tambah Laporan
    </a>
</div>

<form method="GET" class="bg-white rounded-xl shadow p-4 mb-4 flex gap-3 text-sm">
    <select name="status"
            class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
        <option value="">Semua Status</option>
        <option value="draf"            {{ request('status') === 'draf'            ? 'selected' : '' }}>Draf</option>
        <option value="dipublikasikan"  {{ request('status') === 'dipublikasikan' ? 'selected' : '' }}>Dipublikasikan</option>
    </select>
    <button type="submit"
            class="bg-cokelat-tanah text-white px-4 py-2 rounded-lg font-semibold hover:bg-cokelat-tanah/90">
        Filter
    </button>
</form>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-hijau-daun text-white">
            <tr>
                <th class="px-4 py-3 text-left">Periode</th>
                <th class="px-4 py-3 text-left">Desa</th>
                <th class="px-4 py-3 text-right">Pemasukan</th>
                <th class="px-4 py-3 text-right">Pengeluaran</th>
                <th class="px-4 py-3 text-right">Saldo</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse ($laporan as $l)
                <tr>
                    <td class="px-4 py-3 font-semibold">{{ $l->periode }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $l->desa->nama ?? '-' }}</td>
                    <td class="px-4 py-3 text-right text-hijau-daun">Rp {{ number_format($l->pemasukan, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-right text-cokelat-tanah">Rp {{ number_format($l->pengeluaran, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-right font-semibold">Rp {{ number_format($l->saldo, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-1 rounded-full font-semibold
                            {{ $l->status === 'dipublikasikan' ? 'bg-hijau-daun/15 text-hijau-daun' : 'bg-gray-200 text-gray-600' }}">
                            {{ ucfirst($l->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <a href="{{ route('admin.laporan.edit', $l) }}"
                           class="text-hijau-daun text-xs font-semibold hover:underline">Edit</a>
                        <form action="{{ route('admin.laporan.destroy', $l) }}" method="POST" class="inline ml-3"
                              onsubmit="return confirm('Yakin hapus laporan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">Belum ada laporan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $laporan->links() }}</div>

@endsection