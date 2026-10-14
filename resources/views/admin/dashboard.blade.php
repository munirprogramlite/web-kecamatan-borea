@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<h1 class="text-2xl font-poppins font-bold text-hijau-daun mb-6">Dashboard</h1>

{{-- Kartu Statistik --}}
<div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
    @foreach ([
        ['label' => 'UMKM',    'nilai' => $totalUmkm,   'ikon' => '🛍️'],
        ['label' => 'Wisata',  'nilai' => $totalWisata, 'ikon' => '🏞️'],
        ['label' => 'Berita',  'nilai' => $totalBerita, 'ikon' => '📰'],
    ] as $s)
        <div class="bg-white rounded-xl shadow p-5">
            <div class="text-3xl mb-2">{{ $s['ikon'] }}</div>
            <div class="text-3xl font-poppins font-bold text-hijau-daun">{{ $s['nilai'] }}</div>
            <div class="text-xs text-gray-600 mt-1">{{ $s['label'] }}</div>
        </div>
    @endforeach
</div>

{{-- Komentar Terbaru --}}
<div class="bg-white rounded-xl shadow p-6">
    <h2 class="font-poppins font-semibold text-lg mb-4">Komentar Terbaru</h2>

    @forelse ($komentarTerbaru as $k)
        <div class="border-b last:border-b-0 py-3 flex justify-between items-start gap-4">
            <div>
                <div class="text-sm">
                    <span class="font-semibold text-hijau-daun">{{ $k->user->nama_akun ?? 'Anonim' }}</span>
                    <span class="text-gray-400 text-xs ml-2">{{ $k->dibuat_pada?->diffForHumans() }}</span>
                </div>
                <p class="text-sm text-gray-700 mt-1">{{ \Illuminate\Support\Str::limit($k->isi, 120) }}</p>
                <div class="text-[11px] text-gray-400 mt-1 uppercase">
                    {{ $k->target_tipe }}
                </div>
            </div>
            <form action="{{ route('komentar.destroy', $k) }}" method="POST"
                  onsubmit="return confirm('Hapus komentar ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs text-red-500 hover:underline">Hapus</button>
            </form>
        </div>
    @empty
        <p class="text-sm text-gray-500 italic">Belum ada komentar.</p>
    @endforelse
</div>

@endsection