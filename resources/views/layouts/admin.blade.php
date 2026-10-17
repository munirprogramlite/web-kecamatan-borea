<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Kecamatan Borea</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-krem font-inter text-abu-gelap min-h-screen">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-hijau-daun text-white hidden md:flex md:flex-col">
        <div class="p-5 border-b border-white/20">
            <a href="{{ url('/admin') }}" class="block">
                <div class="text-xl font-poppins font-bold">Borea</div>
                <div class="text-xs opacity-75">Panel Admin</div>
            </a>
        </div>

        <nav class="flex-1 p-4 space-y-1 text-sm">
            @php
                        $menu = [
            ['label' => 'Dashboard', 'url' => url('/admin'),                'ikon' => '📊'],
            ['label' => 'Desa',      'url' => url('/admin/desa'),           'ikon' => '🏘️'],  // ← BARU
            ['label' => 'UMKM',      'url' => url('/admin/umkm'),           'ikon' => '🛍️'],
            ['label' => 'Wisata',    'url' => url('/admin/wisata'),         'ikon' => '🏞️'],
            ['label' => 'Berita',    'url' => url('/admin/berita'),         'ikon' => '📰'],
            ['label' => 'Laporan',   'url' => url('/admin/laporan'),        'ikon' => '💰'],
            ['label' => 'Data Warga','url' => url('/admin/warga'),          'ikon' => '👥'],
            ['label' => 'Komentar',  'url' => url('/admin/komentar'),       'ikon' => '💬'],
        ];
            @endphp

            @foreach ($menu as $m)
    @php
        // Cek menu aktif berdasarkan URL
        $currentPath = request()->path();
        $menuPath = ltrim(parse_url($m['url'], PHP_URL_PATH), '/');
        $isActive = $currentPath === $menuPath
                    || ($menuPath !== 'admin' && str_starts_with($currentPath, $menuPath . '/'));
    @endphp
    <a href="{{ $m['url'] }}"
       class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/10 transition
              {{ $isActive ? 'bg-white/15 font-semibold' : '' }}">
        <span>{{ $m['ikon'] }}</span>
        <span>{{ $m['label'] }}</span>
    </a>
@endforeach
        </nav>

        <div class="p-4 border-t border-white/20 text-xs">
            <div class="mb-2 opacity-75">
                Login sebagai <strong>{{ auth()->user()->nama_akun }}</strong>
                @if (auth()->user()->desa_id)
                    <br><span class="text-[10px]">Admin Desa</span>
                @else
                    <br><span class="text-[10px]">Admin Kecamatan</span>
                @endif
            </div>
            <a href="{{ url('/borea') }}" class="block text-center bg-white/15 hover:bg-white/25 px-3 py-1.5 rounded text-[11px] mb-2">
                Lihat Situs Publik
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-cokelat-tanah hover:bg-cokelat-tanah/90 px-3 py-1.5 rounded text-[11px] font-semibold">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- KONTEN UTAMA --}}
    <main class="flex-1 flex flex-col">

        {{-- TOPBAR mobile --}}
        <header class="md:hidden bg-hijau-daun text-white p-4 flex justify-between items-center">
            <div class="font-poppins font-bold">Borea Admin</div>
            <a href="{{ url('/borea') }}" class="text-xs underline">Situs Publik</a>
        </header>

        <div class="flex-1 p-6 md:p-8">
            @if (session('sukses'))
                <div class="mb-4 bg-hijau-daun/10 border border-hijau-daun text-hijau-daun text-sm rounded-lg p-3">
                    {{ session('sukses') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 text-sm rounded-lg p-3">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</div>

</body>
</html>