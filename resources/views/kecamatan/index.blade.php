@extends('layouts.public')

@section('title', 'Kecamatan Borea')

@section('content')

    {{-- HERO --}}
    <section class="relative hero-gradient text-white overflow-hidden">
        <div class="absolute inset-0 pattern-dots opacity-40"></div>

        <div class="relative max-w-6xl mx-auto px-4 py-16 md:py-24 text-center">
            <div class="animate-fade-up">
                <div class="inline-block px-4 py-1 rounded-full bg-white/15 text-xs font-semibold tracking-wider uppercase mb-4">
                    Selamat Datang
                </div>
                <h1 class="text-4xl md:text-5xl font-poppins font-bold mb-4 leading-tight">
                    Kecamatan Borea
                </h1>
                <p class="max-w-2xl mx-auto text-base md:text-lg opacity-90 leading-relaxed">
                    Jelajahi profil, UMKM, wisata, berita, dan transparansi keuangan
                    dari tiga desa kami: <strong>Hainan</strong>, <strong>Joreu</strong>, dan <strong>Kartula</strong>.
                </p>
            </div>
        </div>

        {{-- Wave divider --}}
        <svg class="absolute bottom-0 left-0 w-full h-12 md:h-16" viewBox="0 0 1440 60" preserveAspectRatio="none">
            <path fill="#FAF7F0" d="M0,30 C240,60 480,0 720,20 C960,40 1200,10 1440,30 L1440,60 L0,60 Z"></path>
        </svg>
    </section>

    {{-- REKAP ANGKA --}}
    <section class="max-w-6xl mx-auto px-4 -mt-10 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
                $rekap = [
                    ['label' => 'Jumlah Penduduk', 'nilai' => number_format($totalPenduduk, 0, ',', '.'), 'ikon' => '👥'],
                    ['label' => 'Kartu Keluarga',  'nilai' => number_format($totalKK, 0, ',', '.'),       'ikon' => '🏠'],
                    ['label' => 'UMKM Aktif',      'nilai' => $totalUmkm,                                'ikon' => '🛍️'],
                    ['label' => 'Destinasi Wisata','nilai' => $totalWisata,                              'ikon' => '🏞️'],
                ];
            @endphp

            @foreach ($rekap as $i => $r)
                <div class="bg-white rounded-2xl shadow-md p-5 text-center card-hover animate-fade-up delay-{{ $i * 100 }}">
                    <div class="text-3xl mb-2">{{ $r['ikon'] }}</div>
                    <div class="text-2xl md:text-3xl font-poppins font-bold text-hijau-daun">
                        {{ $r['nilai'] }}
                    </div>
                    <div class="text-xs text-gray-500 mt-1">{{ $r['label'] }}</div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- KARTU DESA --}}
    <section class="max-w-6xl mx-auto px-4 mt-16">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-poppins font-bold text-hijau-daun mb-2">Jelajahi Desa Kami</h2>
            <p class="text-gray-600">Pilih salah satu desa di bawah ini untuk melihat profil lengkapnya.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($desaList as $desa)
                <a href="{{ url('/borea/' . $desa->slug) }}"
                   class="bg-white rounded-2xl shadow-md overflow-hidden card-hover flex flex-col group">
                    <div class="relative h-44 overflow-hidden">
                        <img src="https://picsum.photos/seed/{{ $desa->slug }}/600/400"
                             alt="Desa {{ $desa->nama }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-3 left-4 text-white">
                            <div class="text-xs opacity-80 uppercase tracking-wider">Desa</div>
                            <div class="text-2xl font-poppins font-bold">{{ $desa->nama }}</div>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <p class="text-sm text-gray-600 flex-1 line-clamp-3">
                            {{ $desa->sambutan }}
                        </p>
                        <span class="mt-4 inline-flex items-center gap-1 text-hijau-daun font-semibold text-sm">
                            Jelajahi Desa
                            <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- BERITA TERBARU --}}
    @if ($beritaTerbaru->count())
        <section class="max-w-6xl mx-auto px-4 mt-16">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-poppins font-bold text-hijau-daun mb-2">Berita Terbaru</h2>
                <p class="text-gray-600">Kabar terkini dari tiga desa.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($beritaTerbaru as $berita)
                    <article class="bg-white rounded-2xl shadow-md p-6 card-hover flex flex-col">
                        <div class="inline-block self-start px-3 py-1 rounded-full bg-hijau-daun/10 text-hijau-daun text-xs font-semibold mb-3">
                            Desa {{ $berita->desa->nama }}
                        </div>
                        <h3 class="font-poppins font-semibold text-lg mb-2 line-clamp-2">
                            {{ $berita->judul }}
                        </h3>
                        <p class="text-sm text-gray-600 mb-4 flex-1 line-clamp-3">
                            {{ $berita->isi }}
                        </p>
                        <div class="text-xs text-gray-400 pt-3 border-t">
                            {{ $berita->tanggal_tayang->translatedFormat('d F Y') }}
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

@endsection