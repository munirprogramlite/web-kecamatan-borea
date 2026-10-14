@extends('layouts.public')

@section('title', $umkm->nama)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">

    @include('partials.back-link', ['desa' => $desa])

    <h1 class="text-3xl md:text-4xl font-poppins font-bold text-hijau-daun mb-2 animate-fade-up">
        {{ $umkm->nama }}
    </h1>
    <div class="inline-block px-3 py-1 rounded-full bg-cokelat-tanah/15 text-cokelat-tanah text-xs font-semibold uppercase mb-6">
        UMKM Desa {{ $desa->nama }}
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-[1.618fr_1fr] gap-8">

        {{-- KIRI --}}
        <div>
            <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-6 animate-fade-in">
                <div class="aspect-video bg-cokelat-tanah/10 flex items-center justify-center text-6xl">
                    @if ($umkm->foto)
                        <img src="{{ asset('storage/' . $umkm->foto) }}" alt="{{ $umkm->nama }}" class="w-full h-full object-cover">
                    @else
                        <img src="https://picsum.photos/seed/{{ $umkm->slug }}/1200/675" alt="{{ $umkm->nama }}" class="w-full h-full object-cover">
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6">
                <h2 class="font-poppins font-semibold text-xl mb-3 text-hijau-daun">Deskripsi</h2>
                <p class="text-gray-700 leading-relaxed">{{ $umkm->deskripsi ?? 'Belum ada deskripsi.' }}</p>
            </div>
        </div>

        {{-- KANAN --}}
        <aside class="space-y-4">

            @if ($umkm->menu)
                <div class="bg-white rounded-2xl shadow-md p-5">
                    <h3 class="font-poppins font-semibold mb-3 text-cokelat-tanah flex items-center gap-2">
                        <span>🍽️</span> Menu & Harga
                    </h3>
                    <div class="text-sm text-gray-700 whitespace-pre-line leading-relaxed">{{ $umkm->menu }}</div>
                </div>
            @endif

            @if ($umkm->alamat)
                <div class="bg-white rounded-2xl shadow-md p-5">
                    <h3 class="font-poppins font-semibold mb-2 text-cokelat-tanah flex items-center gap-2">
                        <span>📍</span> Alamat
                    </h3>
                    <p class="text-sm text-gray-700">{{ $umkm->alamat }}</p>
                </div>
            @endif

            @if ($umkm->kontak)
                <div class="bg-white rounded-2xl shadow-md p-5">
                    <h3 class="font-poppins font-semibold mb-2 text-cokelat-tanah flex items-center gap-2">
                        <span>💬</span> Kontak WhatsApp
                    </h3>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $umkm->kontak) }}"
                       target="_blank"
                       class="inline-block w-full text-center bg-hijau-daun text-white px-4 py-2.5 rounded-lg text-sm font-semibold hover:bg-hijau-daun/90 transition">
                        Chat via WhatsApp
                    </a>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-md p-5">
                @include('partials.komentar', [
                    'targetTipe' => 'umkm',
                    'targetId'   => $umkm->id,
                    'komentarList' => $komentar,
                ])
            </div>

        </aside>
    </div>
</div>
@endsection