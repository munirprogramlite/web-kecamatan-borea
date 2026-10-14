@extends('layouts.admin')

@section('title', 'Moderasi Komentar')

@section('content')

<h1 class="text-2xl font-poppins font-bold text-hijau-daun mb-6">Moderasi Komentar</h1>

<form method="GET" class="bg-white rounded-xl shadow p-4 mb-4 flex gap-3 text-sm">
    <select name="tipe"
            class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
        <option value="">Semua Tipe</option>
        <option value="umkm"   {{ request('tipe') === 'umkm'   ? 'selected' : '' }}>UMKM</option>
        <option value="wisata" {{ request('tipe') === 'wisata' ? 'selected' : '' }}>Wisata</option>
    </select>
    <button type="submit"
            class="bg-cokelat-tanah text-white px-4 py-2 rounded-lg font-semibold hover:bg-cokelat-tanah/90">
        Filter
    </button>
</form>

<div class="space-y-3">
    @forelse ($komentar as $k)
        @php
            if ($k->target_tipe === 'umkm') {
                $target = \App\Models\Umkm::find($k->target_id);
                $targetNama = $target?->nama ?? '(UMKM dihapus)';
            } else {
                $target = \App\Models\Wisata::find($k->target_id);
                $targetNama = $target?->nama ?? '(Wisata dihapus)';
            }
        @endphp
        <div class="bg-white rounded-xl shadow p-5">
            <div class="flex justify-between items-start gap-4">
                <div class="flex-1">
                    <div class="text-sm mb-1">
                        <span class="font-semibold text-hijau-daun">{{ $k->user->nama_akun ?? 'Anonim' }}</span>
                        <span class="text-gray-400 text-xs ml-2">{{ $k->dibuat_pada?->diffForHumans() }}</span>
                    </div>
                    <div class="text-xs text-cokelat-tanah font-semibold uppercase mb-2">
                        {{ $k->target_tipe }}: {{ $targetNama }}
                    </div>
                    <p class="text-sm text-gray-700">{{ $k->isi }}</p>
                </div>
                <form action="{{ route('admin.komentar.destroy', $k) }}" method="POST"
                      onsubmit="return confirm('Hapus komentar ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="text-xs bg-red-500 text-white px-3 py-1.5 rounded-lg font-semibold hover:bg-red-600">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl shadow p-8 text-center text-gray-500">
            Belum ada komentar.
        </div>
    @endforelse
</div>

<div class="mt-4">{{ $komentar->links() }}</div>

@endsection