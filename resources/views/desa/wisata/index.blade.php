@extends('layouts.public')

@section('title', 'Wisata Desa ' . $desa->nama)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">

    @include('partials.back-link', ['desa' => $desa])

    <div class="text-center mb-10">
        <div class="inline-block px-4 py-1 rounded-full bg-hijau-daun/10 text-hijau-daun text-xs font-semibold tracking-wider uppercase mb-3">
            🏞️ Wisata
        </div>
        <h1 class="text-3xl md:text-4xl font-poppins font-bold text-hijau-daun mb-2">
            Wisata Desa {{ $desa->nama }}
        </h1>
        <p class="text-gray-600">Destinasi menarik di desa kami.</p>
    </div>

    @if ($wisata->count())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($wisata as $w)
                <a href="{{ route('desa.wisata.detail', [$desa->slug, $w->slug]) }}"
                   class="bg-white rounded-2xl shadow-md overflow-hidden card-hover flex flex-col group">
                    <div class="h-48 overflow-hidden">
                        @include('partials.image-placeholder', [
                            'tipe' => 'wisata',
                            'nama' => $w->nama,
                            'slug' => $w->slug,
                            'foto' => $w->foto,
                            'kelas' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500',
                        ])
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="inline-block self-start px-2 py-1 rounded-full bg-cokelat-tanah/10 text-cokelat-tanah text-xs font-semibold mb-2">
                            🎟️ {{ $w->harga_tiket ?? 'Gratis' }}
                        </div>
                        <h3 class="font-poppins font-semibold text-lg mb-2 line-clamp-2">{{ $w->nama }}</h3>
                        <p class="text-sm text-gray-600 flex-1 line-clamp-3">{{ $w->deskripsi }}</p>
                        <span class="mt-3 inline-flex items-center gap-1 text-hijau-daun font-semibold text-sm">
                            Lihat Detail
                            <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-md p-12 text-center">
            <div class="text-5xl mb-3">🏞️</div>
            <p class="text-gray-500">Belum ada wisata untuk desa ini.</p>
        </div>
    @endif

</div>
@endsection