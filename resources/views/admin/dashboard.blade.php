@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-poppins font-bold text-gray-800">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
    <p class="text-gray-500 mt-1">Berikut adalah ringkasan data untuk Kecamatan Borea.</p>
</div>

{{-- Kartu Statistik --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    @foreach ([
        ['label' => 'Total UMKM',   'nilai' => $totalUmkm,   'ikon' => '🛍️', 'bg' => 'bg-gradient-to-br from-amber-400 to-orange-500', 'text' => 'text-white'],
        ['label' => 'Total Wisata', 'nilai' => $totalWisata, 'ikon' => '🏞️', 'bg' => 'bg-gradient-to-br from-emerald-400 to-teal-500', 'text' => 'text-white'],
        ['label' => 'Total Berita', 'nilai' => $totalBerita, 'ikon' => '📰', 'bg' => 'bg-gradient-to-br from-sky-400 to-blue-500', 'text' => 'text-white'],
    ] as $s)
        <div class="rounded-2xl shadow-lg p-6 relative overflow-hidden {{ $s['bg'] }} {{ $s['text'] }} transform hover:-translate-y-1 transition duration-300">
            {{-- Ornamen Background --}}
            <div class="absolute -right-4 -bottom-4 text-7xl opacity-20">{{ $s['ikon'] }}</div>
            
            <div class="relative z-10">
                <div class="text-sm font-semibold uppercase tracking-wider mb-2 opacity-90">{{ $s['label'] }}</div>
                <div class="text-4xl font-poppins font-bold">{{ $s['nilai'] }}</div>
            </div>
        </div>
    @endforeach
</div>

{{-- Komentar Terbaru --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="font-poppins font-bold text-lg text-gray-800">💬 Komentar Terbaru</h2>
        <a href="{{ route('admin.komentar.index') }}" class="text-sm text-hijau-daun font-semibold hover:underline">Lihat Semua</a>
    </div>

    @forelse ($komentarTerbaru as $k)
        <div class="border-b border-gray-50 last:border-0 py-4 flex justify-between items-start gap-4 hover:bg-gray-50 px-2 rounded-lg transition">
            <div class="flex gap-3">
                <div class="w-10 h-10 rounded-full bg-cokelat-tanah/10 text-cokelat-tanah flex items-center justify-center font-bold flex-shrink-0">
                    {{ substr($k->user->nama_akun ?? 'A', 0, 1) }}
                </div>
                <div>
                    <div class="text-sm">
                        <span class="font-bold text-gray-800">{{ $k->user->nama_akun ?? 'Anonim' }}</span>
                        <span class="text-gray-400 text-xs ml-2">{{ $k->dibuat_pada?->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $k->isi }}</p>
                    <div class="text-[10px] font-bold text-hijau-daun mt-2 bg-hijau-daun/10 inline-block px-2 py-0.5 rounded uppercase">
                        {{ $k->target_tipe }}
                    </div>
                </div>
            </div>
            <form action="{{ route('admin.komentar.destroy', $k) }}" method="POST"
                  onsubmit="return confirm('Hapus komentar ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs text-red-500 hover:bg-red-50 px-2 py-1 rounded transition">Hapus</button>
            </form>
        </div>
    @empty
        <div class="text-center py-8">
            <div class="text-4xl mb-2">📭</div>
            <p class="text-gray-500">Belum ada komentar masuk.</p>
        </div>
    @endforelse
</div>

@endsection