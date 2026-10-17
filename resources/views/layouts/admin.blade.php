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
    <style>
        [x-cloak] { display: none !important; }
        /* Custom scrollbar untuk sidebar */
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }
    </style>
</head>
<body class="bg-[#f4f7f6] font-inter text-abu-gelap min-h-screen overflow-hidden" 
      x-data="{ sidebarOpen: window.innerWidth > 768 }" 
      @resize.window="sidebarOpen = window.innerWidth > 768">

<div class="flex h-screen overflow-hidden">

    {{-- OVERLAY GELAP (Hanya muncul di HP saat sidebar terbuka) --}}
    <div x-show="sidebarOpen" 
         x-transition.opacity.duration.300ms
         class="fixed inset-0 bg-black/50 z-40 md:hidden" 
         @click="sidebarOpen = false"
         x-cloak></div>

    {{-- SIDEBAR --}}
    <aside 
        class="fixed md:relative inset-y-0 left-0 z-50 bg-gradient-to-b from-[#183c2b] to-[#2F6B4F] text-white flex flex-col transition-all duration-300 ease-in-out shadow-2xl md:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0 w-64' : '-translate-x-full md:w-20'"
    >
        {{-- Logo --}}
        <div class="h-16 flex items-center justify-between px-4 border-b border-white/10 bg-black/10">
            <a href="{{ url('/admin') }}" class="flex items-center gap-3 overflow-hidden whitespace-nowrap">
                <div class="w-8 h-8 flex-shrink-0 bg-white/20 rounded-lg flex items-center justify-center text-lg">🌿</div>
                <div x-show="sidebarOpen" x-transition.opacity class="font-poppins font-bold tracking-wider">
                    BOREA
                </div>
            </a>
        </div>

        {{-- Menu Navigasi --}}
        <nav class="flex-1 px-3 py-4 space-y-1 text-sm overflow-y-auto custom-scrollbar">
            @php
                $menu = [
                    ['label' => 'Dashboard', 'url' => url('/admin'),                'ikon' => '📊'],
                    ['label' => 'Desa',      'url' => url('/admin/desa'),           'ikon' => '🏘️'],
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
                    $currentPath = request()->path();
                    $menuPath = ltrim(parse_url($m['url'], PHP_URL_PATH), '/');
                    $isActive = $currentPath === $menuPath
                                || ($menuPath !== 'admin' && str_starts_with($currentPath, $menuPath . '/'));
                @endphp
                <a href="{{ $m['url'] }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                          {{ $isActive ? 'bg-white text-[#2F6B4F] shadow-md font-bold' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                    <span class="text-lg flex-shrink-0 transition-transform group-hover:scale-110">{{ $m['ikon'] }}</span>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">{{ $m['label'] }}</span>
                </a>
            @endforeach
        </nav>

        {{-- User & Logout --}}
        <div class="p-4 border-t border-white/10 bg-black/20">
            <div class="flex items-center gap-3 mb-4 overflow-hidden whitespace-nowrap">
                <div class="w-8 h-8 flex-shrink-0 rounded-full bg-cokelat-tanah flex items-center justify-center font-bold text-white">
                    {{ substr(auth()->user()->nama_akun, 0, 1) }}
                </div>
                <div x-show="sidebarOpen" x-transition.opacity>
                    <div class="text-xs font-bold text-white">{{ auth()->user()->nama_akun }}</div>
                    <div class="text-[10px] text-gray-300">
                        {{ auth()->user()->desa_id ? 'Admin Desa' : 'Admin Kecamatan' }}
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col gap-2" :class="sidebarOpen ? '' : 'items-center'">
                <a href="{{ url('/borea') }}" class="flex items-center gap-2 text-xs text-gray-300 hover:text-white transition" title="Lihat Situs">
                    <span>🌐</span> <span x-show="sidebarOpen">Lihat Situs</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 text-xs text-red-300 hover:text-red-100 transition" title="Logout">
                        <span>🚪</span> <span x-show="sidebarOpen">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- KONTEN UTAMA --}}
    <main class="flex-1 flex flex-col h-screen overflow-hidden w-full relative">

        {{-- TOPBAR --}}
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-4 md:px-6 z-30 sticky top-0">
            <div class="flex items-center gap-3 md:gap-4">
                {{-- Tombol Toggle Sidebar (Mobile & Desktop) --}}
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <h2 class="font-poppins font-bold text-lg text-gray-700 hidden sm:block">@yield('title', 'Dashboard')</h2>
            </div>
            
            <div class="flex items-center gap-3 text-sm">
                <span class="text-gray-500 hidden sm:block">Halo, <strong class="text-hijau-daun">{{ auth()->user()->name }}</strong></span>
                {{-- Avatar kecil untuk mobile --}}
                <div class="w-8 h-8 sm:hidden rounded-full bg-hijau-daun text-white flex items-center justify-center font-bold">
                    {{ substr(auth()->user()->nama_akun, 0, 1) }}
                </div>
            </div>
        </header>

        {{-- AREA SCROLL KONTEN --}}
        <div class="flex-1 overflow-y-auto p-4 md:p-8">
            @if (session('sukses'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-lg shadow-sm flex items-center gap-3">
                    <span class="text-xl">✅</span>
                    <div>{{ session('sukses') }}</div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg shadow-sm flex items-center gap-3">
                    <span class="text-xl">⚠️</span>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</div>

</body>
</html>