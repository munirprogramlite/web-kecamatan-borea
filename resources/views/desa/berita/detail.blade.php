@extends('layouts.public')

@section('title', $berita->judul)

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">

    @include('partials.back-link', ['desa' => $desa])

    <div class="text-xs text-cokelat-tanah font-semibold uppercase mb-2">
        Desa {{ $desa->nama }} · {{ $berita->tanggal_tayang->translatedFormat('d F Y') }}
    </div>

    <h1 class="text-3xl md:text-4xl font-poppins font-bold text-hijau-daun mb-6 animate-fade-up">
        {{ $berita->judul }}
    </h1>

    <article class="bg-white rounded-2xl shadow-md p-6 md:p-8 text-gray-700 leading-relaxed">
        {!! nl2br(e($berita->isi)) !!}
    </article>

    <div class="mt-6">
        <a href="{{ route('desa.berita', $desa->slug) }}"
           class="text-sm text-hijau-daun font-semibold hover:underline">
            &larr; Kembali ke daftar berita
        </a>
    </div>

</div>
@endsection