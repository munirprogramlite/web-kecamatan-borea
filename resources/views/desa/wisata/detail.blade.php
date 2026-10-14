@extends('layouts.public')

@section('title', $wisata->nama)

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">

    <div class="mb-6">
        @include('partials.back-link', ['desa' => $desa])
    </div>

    <h1 class="text-3xl md:text-4xl font-poppins font-bold text-hijau-daun mb-4">{{ $wisata->nama }}</h1>

    <div class="bg-white rounded-xl shadow overflow-hidden mb-6">
        <div class="aspect-video bg-hijau-daun/20 flex items-center justify-center text-6xl">
            @if ($wisata->foto)
                <img src="{{ asset('storage/' . $wisata->foto) }}" alt="{{ $wisata->nama }}" class="w-full h-full object-cover">
            @else
                🏞️
            @endif
        </div>
    </div>

    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="font-poppins font-semibold text-xl mb-3">Deskripsi</h2>
        <p class="text-gray-700 leading-relaxed">{{ $wisata->deskripsi ?? 'Belum ada deskripsi.' }}</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="font-poppins font-semibold text-xl mb-4">Informasi Praktis</h2>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
                <dt class="text-gray-500">Harga Tiket</dt>
                <dd class="font-semibold text-cokelat-tanah">{{ $wisata->harga_tiket ?? 'Gratis' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Jam Buka</dt>
                <dd class="font-semibold">{{ $wisata->jam_buka ?? '-' }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-gray-500">Alamat</dt>
                <dd class="font-semibold">{{ $wisata->alamat ?? '-' }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-gray-500">Kontak</dt>
                <dd class="font-semibold">
                    @if ($wisata->kontak)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $wisata->kontak) }}"
                           target="_blank"
                           class="text-hijau-daun underline">
                            {{ $wisata->kontak }}
                        </a>
                    @else
                        -
                    @endif
                </dd>
            </div>
        </dl>
    </div>

    {{-- Panel komentar --}}
    <div class="bg-white rounded-xl shadow p-6">
        @include('partials.komentar', [
            'targetTipe' => 'wisata',
            'targetId'   => $wisata->id,
            'komentarList' => $komentar,
        ])
    </div>

</div>
@endsection