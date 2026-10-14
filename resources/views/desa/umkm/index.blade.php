@extends('layouts.public')

@section('title', 'UMKM Desa ' . $desa->nama)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">

    <div class="mb-6">
        @include('partials.back-link', ['desa' => $desa])
    </div>

    <h1 class="text-3xl font-poppins font-bold text-hijau-daun mb-6">UMKM Desa {{ $desa->nama }}</h1>

    @if ($umkm->count())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($umkm as $u)
                <a href="{{ route('desa.umkm.detail', [$desa->slug, $u->slug]) }}"
                   class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden flex flex-col">
                    <div class="h-40 bg-cokelat-tanah/20 flex items-center justify-center text-4xl">
                        @if ($u->foto)
                            <img src="{{ asset('storage/' . $u->foto) }}" alt="{{ $u->nama }}" class="w-full h-full object-cover">
                        @else
                            🛍️
                        @endif
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <h3 class="font-poppins font-semibold text-lg mb-1">{{ $u->nama }}</h3>
                        <p class="text-xs text-cokelat-tanah font-semibold uppercase mb-2">UMKM</p>
                        <p class="text-sm text-gray-600 flex-1">{{ \Illuminate\Support\Str::limit($u->deskripsi, 80) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">Belum ada UMKM untuk desa ini.</p>
    @endif

</div>
@endsection