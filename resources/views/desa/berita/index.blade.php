@extends('layouts.public')

@section('title', 'Berita Desa ' . $desa->nama)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">

    @include('partials.back-link', ['desa' => $desa])

    <div class="text-center mb-8">
        <h1 class="text-3xl md:text-4xl font-poppins font-bold text-hijau-daun mb-2">
            Berita Desa {{ $desa->nama }}
        </h1>
        <p class="text-gray-600">Kabar dan kegiatan terbaru dari Desa {{ $desa->nama }}.</p>
    </div>

    @if ($berita->count())
        <div class="space-y-4">
            @foreach ($berita as $b)
                <a href="{{ route('desa.berita.detail', [$desa->slug, $b->slug]) }}"
                   class="block bg-white rounded-2xl shadow-md p-6 card-hover">
                    <div class="text-xs text-cokelat-tanah font-semibold uppercase mb-2">
                        {{ $b->tanggal_tayang->translatedFormat('d F Y') }}
                    </div>
                    <h2 class="font-poppins font-semibold text-xl mb-2 line-clamp-2">
                        {{ $b->judul }}
                    </h2>
                    <p class="text-gray-600 text-sm line-clamp-3">
                        {{ $b->isi }}
                    </p>
                    <span class="mt-3 inline-block text-hijau-daun font-semibold text-sm">
                        Baca selengkapnya →
                    </span>
                </a>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl shadow p-12 text-center text-gray-500">
            Belum ada berita untuk desa ini.
        </div>
    @endif

</div>
@endsection