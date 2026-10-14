<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kecamatan Borea')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-krem text-abu-gelap font-inter min-h-screen flex flex-col">

    {{-- HEADER STICKY --}}
    <header class="bg-hijau-daun text-white shadow-md sticky top-0 z-40 backdrop-blur-sm bg-hijau-daun/95">
        <div class="max-w-6xl mx-auto px-4 py-3 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <a href="{{ url('/borea') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-full bg-white/15 flex items-center justify-center text-xl group-hover:bg-white/25 transition">
                    🌿
                </div>
                <div>
                    <div class="text-lg font-poppins font-bold leading-tight">Borea</div>
                    <div class="text-[10px] opacity-70 tracking-widest uppercase">Kecamatan</div>
                </div>
            </a>

            <nav class="flex flex-wrap gap-1 text-sm font-medium items-center">
                @php $menuDesa = \App\Models\Desa::orderBy('id')->get(); @endphp

                @foreach ($menuDesa as $d)
                    <a href="{{ url('/borea/' . $d->slug) }}"
                       class="px-3 py-1.5 rounded-full hover:bg-white/15 transition">
                        {{ $d->nama }}
                    </a>
                @endforeach

                @auth
                    @if (auth()->user()->peran === 'admin')
                        <a href="{{ url('/admin') }}"
                           class="px-3 py-1.5 rounded-full bg-white text-hijau-daun font-semibold hover:bg-krem transition">
                            Admin
                        </a>
                    @endif
                    <div class="flex items-center gap-2 pl-2 ml-1 border-l border-white/30">
                        <span class="text-xs opacity-80 hidden md:inline">
                            Hai, <strong>{{ auth()->user()->nama_akun }}</strong>
                        </span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="px-3 py-1.5 rounded-full bg-cokelat-tanah hover:bg-cokelat-tanah/90 text-white text-xs font-semibold transition">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-3 py-1.5 rounded-full hover:bg-white/15 transition">
                        Masuk
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    {{-- KONTEN --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- FOOTER BERISI --}}
    <footer class="bg-hijau-daun text-white mt-16">
        <div class="max-w-6xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-2xl">🌿</span>
                    <span class="font-poppins font-bold text-lg">Kecamatan Borea</span>
                </div>
                <p class="text-sm opacity-80 leading-relaxed">
                    Website informasi resmi Kecamatan Borea dan tiga desa di bawahnya:
                    Hainan, Joreu, dan Kartula.
                </p>
            </div>

            <div>
                <h4 class="font-poppins font-semibold mb-3 text-sm tracking-wider uppercase opacity-90">Menu Cepat</h4>
                <ul class="space-y-2 text-sm opacity-80">
                    <li><a href="{{ url('/borea') }}" class="hover:underline">Landing Kecamatan</a></li>
                    <li><a href="{{ url('/borea/hainan') }}" class="hover:underline">Desa Hainan</a></li>
                    <li><a href="{{ url('/borea/joreu') }}" class="hover:underline">Desa Joreu</a></li>
                    <li><a href="{{ url('/borea/kartula') }}" class="hover:underline">Desa Kartula</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-poppins font-semibold mb-3 text-sm tracking-wider uppercase opacity-90">Tentang</h4>
                <p class="text-sm opacity-80 leading-relaxed">
                    Dibuat untuk keperluan tugas kuliah.<br>
                    Semua data yang ditampilkan adalah <em>data simulasi</em>.
                </p>
            </div>
        </div>
        <div class="border-t border-white/15">
            <div class="max-w-6xl mx-auto px-4 py-4 text-center text-xs opacity-70">
                &copy; {{ date('Y') }} Kecamatan Borea. Dibuat untuk tugas kuliah.
            </div>
        </div>
    </footer>

</body>
</html>