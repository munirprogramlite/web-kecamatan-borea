<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kecamatan Borea') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-inter text-abu-gelap antialiased bg-krem min-h-screen">

    <div class="min-h-screen flex flex-col items-center justify-center py-10 px-4">

        {{-- Logo --}}
        <a href="{{ url('/borea') }}" class="flex items-center gap-2 mb-6 group">
            <div class="w-12 h-12 rounded-full bg-hijau-daun flex items-center justify-center text-2xl text-white group-hover:scale-105 transition">
                🌿
            </div>
            <div>
                <div class="text-xl font-poppins font-bold text-hijau-daun leading-tight">Borea</div>
                <div class="text-[10px] text-gray-500 uppercase tracking-widest">Kecamatan</div>
            </div>
        </a>

        {{-- Card --}}
        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-lg overflow-hidden rounded-2xl animate-fade-up">
            {{ $slot }}
        </div>

        {{-- Link kembali --}}
        <a href="{{ url('/borea') }}" class="mt-6 text-xs text-gray-500 hover:text-hijau-daun hover:underline">
            &larr; Kembali ke beranda
        </a>

    </div>

</body>
</html>