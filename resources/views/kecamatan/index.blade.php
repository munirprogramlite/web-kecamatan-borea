@extends('layouts.public')

@section('title', 'Kecamatan Borea')

@section('content')

    {{-- HERO --}}
    <section class="relative hero-gradient text-white overflow-hidden">
        <div class="absolute inset-0 pattern-dots opacity-40"></div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>

        <div class="relative max-w-6xl mx-auto px-4 py-20 md:py-28 text-center">
            <div class="animate-fade-up">
                <div class="inline-block px-4 py-1 rounded-full bg-white/15 text-xs font-semibold tracking-wider uppercase mb-5 backdrop-blur-sm">
                    ✨ Selamat Datang
                </div>
                <h1 class="text-4xl md:text-6xl font-poppins font-bold mb-5 leading-tight">
                    Kecamatan <span class="text-yellow-300">Borea</span>
                </h1>
                <p class="max-w-2xl mx-auto text-base md:text-lg opacity-90 leading-relaxed">
                    Jelajahi profil, UMKM, wisata, berita, dan transparansi keuangan
                    dari desa-desa kami di bawah naungan Kecamatan Borea.
                </p>
            </div>
        </div>

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
                    <div class="w-12 h-12 mx-auto rounded-full bg-hijau-daun/10 flex items-center justify-center text-2xl mb-3">
                        {{ $r['ikon'] }}
                    </div>
                    <div class="text-2xl md:text-3xl font-poppins font-bold text-hijau-daun">
                        {{ $r['nilai'] }}
                    </div>
                    <div class="text-xs text-gray-500 mt-1">{{ $r['label'] }}</div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- SLIDER DESA --}}
    <section class="max-w-6xl mx-auto px-4 mt-16">
        <div class="text-center mb-8">
            <h2 class="text-3xl md:text-4xl font-poppins font-bold text-hijau-daun mb-2">Jelajahi Desa Kami</h2>
            <p class="text-gray-600">Geser untuk melihat semua desa di Kecamatan Borea.</p>
        </div>

        {{-- Swiper Container --}}
        <div class="swiper desaSwiper pb-12">
            <div class="swiper-wrapper">
                @foreach ($desaList as $desa)
                    <div class="swiper-slide h-auto">
                        <a href="{{ url('/borea/' . $desa->slug) }}"
                           class="block bg-white rounded-2xl shadow-md overflow-hidden card-hover h-full flex flex-col group">
                            <div class="relative h-48 overflow-hidden group-hover:scale-105 transition-transform duration-500">
                                @include('partials.image-placeholder', [
                                    'tipe' => 'desa',
                                    'nama' => $desa->nama,
                                    'slug' => $desa->slug, 
                                    'foto' => $desa->foto ?? null,
                                ])
                            </div>
                            <div class="p-6 flex-1 flex flex-col">
                                <h3 class="text-2xl font-poppins font-bold text-hijau-daun mb-2">{{ $desa->nama }}</h3>
                                <p class="text-sm text-gray-600 flex-1 line-clamp-3">{{ $desa->sambutan }}</p>
                                <span class="mt-4 inline-flex items-center gap-1 text-hijau-daun font-semibold text-sm">
                                    Jelajahi Desa
                                    <span class="group-hover:translate-x-1 transition-transform">→</span>
                                </span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="swiper-pagination desaPagination"></div>
            <div class="swiper-button-next desaNext"></div>
            <div class="swiper-button-prev desaPrev"></div>
        </div>
    </section>

    {{-- SLIDER BERITA --}}
    @if ($beritaTerbaru->count())
        <section class="max-w-6xl mx-auto px-4 mt-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-poppins font-bold text-hijau-daun mb-2">Berita Utama</h2>
                <p class="text-gray-600">10 berita terbaru dari seluruh desa.</p>
            </div>

            <div class="swiper beritaSwiper pb-12">
                <div class="swiper-wrapper">
                    @foreach ($beritaTerbaru as $berita)
                        <div class="swiper-slide h-auto">
                            <a href="{{ url('/borea/' . $berita->desa->slug . '/berita/' . $berita->slug) }}"
                               class="block bg-white rounded-2xl shadow-md p-6 card-hover h-full flex flex-col">
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
                                    📅 {{ $berita->tanggal_tayang->translatedFormat('d F Y') }}
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="swiper-pagination beritaPagination"></div>
                <div class="swiper-button-next beritaNext"></div>
                <div class="swiper-button-prev beritaPrev"></div>
            </div>
        </section>
    @endif

    {{-- SWIPER JS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        // ============ Slider Desa ============
        new Swiper('.desaSwiper', {
            slidesPerView: 1,
            spaceBetween: 24,
            loop: {{ $desaList->count() > 3 ? 'true' : 'false' }},
            speed: 600,
            grabCursor: true,
            simulateTouch: true,
            touchStartPreventDefault: false,
            
            // ✨ FITUR SCROLL MOUSE ✨
            mousewheel: {
                forceToAxis: true,      // Fokus ke geser horizontal
                releaseOnEdges: true,   // Kalau slider udah di ujung, scroll kembali ke halaman web
                sensitivity: 1.5,       // Kecepatan geser (makin besar makin sensitif)
            },

            pagination: {
                el: '.desaPagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.desaNext',
                prevEl: '.desaPrev',
            },
            breakpoints: {
                640: { slidesPerView: 2, spaceBetween: 20 },
                1024: { slidesPerView: 3, spaceBetween: 24 },
            },
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
        });

        // ============ Slider Berita ============
        new Swiper('.beritaSwiper', {
            slidesPerView: 1,
            spaceBetween: 24,
            loop: {{ $beritaTerbaru->count() > 3 ? 'true' : 'false' }},
            speed: 600,
            grabCursor: true,
            simulateTouch: true,
            touchStartPreventDefault: false,
            
            // ✨ FITUR SCROLL MOUSE ✨
            mousewheel: {
                forceToAxis: true,
                releaseOnEdges: true,
                sensitivity: 1.5,
            },

            pagination: {
                el: '.beritaPagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.beritaNext',
                prevEl: '.beritaPrev',
            },
            breakpoints: {
                640: { slidesPerView: 2, spaceBetween: 20 },
                1024: { slidesPerView: 3, spaceBetween: 24 },
            },
            autoplay: {
                delay: 8000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
        });

    });
</script>

@endsection