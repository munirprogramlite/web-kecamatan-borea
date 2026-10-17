@props([
    'tipe' => 'umkm',
    'nama' => '',
    'slug' => '',
    'foto' => null,
    'kelas' => 'w-full h-full object-cover',
])

@php
    use Illuminate\Support\Str;

    // Palet gradient fallback per tipe
    $palet = [
        'umkm'   => ['from-amber-600 to-orange-400',  'from-rose-600 to-orange-400'],
        'wisata' => ['from-emerald-600 to-teal-400',  'from-sky-600 to-cyan-400'],
        'desa'   => ['from-emerald-700 to-green-500', 'from-teal-700 to-emerald-500'],
        'berita' => ['from-stone-600 to-neutral-400'],
    ];
    $ikonMap = [
        'umkm'   => '🛍️',
        'wisata' => '🏞️',
        'desa'   => '🏘️',
        'berita' => '📰',
    ];

    $daftar = $palet[$tipe] ?? $palet['umkm'];
    $gradient = $daftar[crc32($nama ?: 'x') % count($daftar)];
    $ikon = $ikonMap[$tipe] ?? '📦';

    // Auto-detect gambar lokal berdasarkan slug
    $slugFinal = $slug ?: Str::slug($nama);
    $gambarLokal = null;
    if ($slugFinal) {
        foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
            $path = public_path("images/{$tipe}/{$slugFinal}.{$ext}");
            if (file_exists($path)) {
                $gambarLokal = "images/{$tipe}/{$slugFinal}.{$ext}";
                break;
            }
        }
    }
@endphp

@if ($foto)
    {{-- Prioritas 1: Upload dari DB --}}
    <img src="{{ asset('storage/' . $foto) }}" alt="{{ $nama }}" class="{{ $kelas }}" loading="lazy">
@elseif ($gambarLokal)
    {{-- Prioritas 2: Gambar lokal di public/images/{tipe}/{slug}.jpg --}}
    <img src="{{ asset($gambarLokal) }}" alt="{{ $nama }}" class="{{ $kelas }}" loading="lazy">
@else
    {{-- Prioritas 3: Placeholder gradient --}}
    <div class="w-full h-full bg-gradient-to-br {{ $gradient }} flex flex-col items-center justify-center text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-15" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
        <div class="relative text-center px-4">
            <div class="text-5xl md:text-6xl mb-2 drop-shadow-lg">{{ $ikon }}</div>
            @if ($nama)
                <div class="text-xs font-semibold uppercase tracking-widest opacity-95">
                    {{ \Illuminate\Support\Str::limit($nama, 30) }}
                </div>
            @endif
        </div>
    </div>
@endif