@extends('layouts.public')

@section('title', 'Desa ' . $desa->nama)

@section('content')

    {{-- HERO DENGAN GAMBAR RANDOM --}}
    <section class="relative text-white overflow-hidden">
        <img src="https://picsum.photos/seed/{{ $desa->slug }}-hero/1600/600"
             alt="Desa {{ $desa->nama }}"
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/40 to-hijau-daun/80"></div>

        <div class="relative max-w-6xl mx-auto px-4 py-16 md:py-24 text-center animate-fade-up">
            <div class="inline-block px-4 py-1 rounded-full bg-white/20 text-xs font-semibold tracking-wider uppercase mb-4 backdrop-blur-sm">
                Desa
            </div>
            <h1 class="text-4xl md:text-5xl font-poppins font-bold mb-4">
                {{ $desa->nama }}
            </h1>
            <p class="max-w-2xl mx-auto text-base md:text-lg opacity-95 leading-relaxed">
                {{ $desa->sambutan }}
            </p>
        </div>
    </section>

    {{-- RINGKASAN ANGKA --}}
    <section class="max-w-6xl mx-auto px-4 -mt-10 relative z-10">
        <div class="grid grid-cols-3 gap-4">
            @foreach ([
                ['label' => 'Jumlah Warga', 'nilai' => number_format($jumlahWarga, 0, ',', '.'), 'ikon' => '👥'],
                ['label' => 'UMKM',         'nilai' => $jumlahUmkm,   'ikon' => '🛍️'],
                ['label' => 'Wisata',       'nilai' => $jumlahWisata, 'ikon' => '🏞️'],
            ] as $i => $r)
                <div class="bg-white rounded-2xl shadow-md p-5 text-center card-hover animate-fade-up delay-{{ $i * 100 }}">
                    <div class="text-2xl mb-1">{{ $r['ikon'] }}</div>
                    <div class="text-2xl md:text-3xl font-poppins font-bold text-hijau-daun">{{ $r['nilai'] }}</div>
                    <div class="text-xs text-gray-500 mt-1">{{ $r['label'] }}</div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- MENU DESA --}}
    <section class="max-w-6xl mx-auto px-4 mt-16">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-poppins font-bold text-hijau-daun mb-2">Menu Desa</h2>
            <p class="text-gray-600">Semua yang perlu kamu tahu tentang Desa {{ $desa->nama }}.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @php
                $menu = [
                    ['label' => 'Profil',  'url' => route('desa.profil', $desa->slug),  'ikon' => '📋', 'desc' => 'Sejarah & statistik'],
                    ['label' => 'Kontak',  'url' => route('desa.kontak', $desa->slug),  'ikon' => '📞', 'desc' => 'Balai & layanan'],
                    ['label' => 'Laporan', 'url' => route('desa.laporan', $desa->slug), 'ikon' => '📊', 'desc' => 'Keuangan desa'],
                    ['label' => 'Berita',  'url' => route('desa.berita', $desa->slug),  'ikon' => '📰', 'desc' => 'Kabar terbaru'],
                    ['label' => 'UMKM',    'url' => url('/borea/' . $desa->slug . '/umkm'),   'ikon' => '🛍️', 'desc' => 'Produk warga'],
                    ['label' => 'Wisata',  'url' => url('/borea/' . $desa->slug . '/wisata'), 'ikon' => '🏞️', 'desc' => 'Destinasi menarik'],
                ];
            @endphp

            @foreach ($menu as $m)
                <a href="{{ $m['url'] }}"
                   class="bg-white rounded-2xl shadow-md p-6 text-center card-hover group">
                    <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">{{ $m['ikon'] }}</div>
                    <div class="font-poppins font-semibold text-hijau-daun mb-1">{{ $m['label'] }}</div>
                    <div class="text-xs text-gray-500">{{ $m['desc'] }}</div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- BERITA TERBARU --}}
    @if ($beritaTerbaru->count())
        <section class="max-w-6xl mx-auto px-4 mt-16">
            <div class="flex justify-between items-baseline mb-6">
                <h2 class="text-2xl font-poppins font-bold text-hijau-daun">Berita Terbaru</h2>
                <a href="{{ route('desa.berita', $desa->slug) }}" class="text-sm text-hijau-daun font-semibold hover:underline">
                    Lihat semua →
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($beritaTerbaru as $b)
                    <a href="{{ route('desa.berita.detail', [$desa->slug, $b->slug]) }}"
                       class="bg-white rounded-2xl shadow-md p-6 card-hover">
                        <div class="text-xs text-cokelat-tanah font-semibold uppercase mb-2">
                            {{ $b->tanggal_tayang->translatedFormat('d M Y') }}
                        </div>
                        <h3 class="font-poppins font-semibold text-lg mb-2 line-clamp-2">{{ $b->judul }}</h3>
                        <p class="text-sm text-gray-600 line-clamp-3">{{ $b->isi }}</p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

@endsection