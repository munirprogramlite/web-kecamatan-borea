@extends('layouts.public')

@section('title', 'Profil Desa ' . $desa->nama)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">

    @include('partials.back-link', ['desa' => $desa])

    <h1 class="text-3xl font-poppins font-bold text-hijau-daun mb-6">Profil Desa {{ $desa->nama }}</h1>

    <section class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="font-poppins font-semibold text-xl mb-2">Sejarah Singkat</h2>
        <p class="text-gray-700">{{ $desa->sejarah ?? 'Belum ada data.' }}</p>
    </section>

    <section class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="font-poppins font-semibold text-xl mb-2">Letak Geografis</h2>
        <p class="text-gray-700">{{ $desa->letak_geografis ?? 'Belum ada data.' }}</p>
    </section>

    <section class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="font-poppins font-semibold text-xl mb-4">Statistik Warga</h2>

        @if ($warga)
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="text-center">
                    <div class="text-2xl font-poppins font-bold text-cokelat-tanah">{{ number_format($warga->jumlah_kk, 0, ',', '.') }}</div>
                    <div class="text-xs text-gray-600">Jumlah KK</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-poppins font-bold text-cokelat-tanah">{{ number_format($warga->jumlah_laki, 0, ',', '.') }}</div>
                    <div class="text-xs text-gray-600">Laki-laki</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-poppins font-bold text-cokelat-tanah">{{ number_format($warga->jumlah_perempuan, 0, ',', '.') }}</div>
                    <div class="text-xs text-gray-600">Perempuan</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-poppins font-bold text-cokelat-tanah">{{ number_format($warga->jumlah_laki + $warga->jumlah_perempuan, 0, ',', '.') }}</div>
                    <div class="text-xs text-gray-600">Total</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-poppins font-semibold text-sm mb-2 text-center">Jenis Kelamin</h3>
                    <canvas id="chartGender"></canvas>
                </div>
                <div>
                    <h3 class="font-poppins font-semibold text-sm mb-2 text-center">Kelompok Usia</h3>
                    <canvas id="chartUsia"></canvas>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                new Chart(document.getElementById('chartGender'), {
                    type: 'bar',
                    data: {
                        labels: ['Laki-laki', 'Perempuan'],
                        datasets: [{
                            data: [{{ $warga->jumlah_laki }}, {{ $warga->jumlah_perempuan }}],
                            backgroundColor: ['#2F6B4F', '#9C6B3E'],
                        }]
                    },
                    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
                });

                new Chart(document.getElementById('chartUsia'), {
                    type: 'bar',
                    data: {
                        labels: ['0-14', '15-64', '65+'],
                        datasets: [{
                            data: [{{ $warga->usia_0_14 }}, {{ $warga->usia_15_64 }}, {{ $warga->usia_65_plus }}],
                            backgroundColor: ['#2F6B4F', '#9C6B3E', '#8a8a8a'],
                        }]
                    },
                    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
                });
            </script>
        @else
            <p class="text-gray-500">Belum ada data statistik warga.</p>
        @endif
    </section>

    {{-- Ringkasan Keuangan (Opsi C) --}}
    <section class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-baseline mb-4">
            <h2 class="font-poppins font-semibold text-xl">Ringkasan Keuangan</h2>
            <a href="{{ route('desa.laporan', $desa->slug) }}" class="text-sm text-hijau-daun font-semibold">
                Lihat laporan lengkap &rarr;
            </a>
        </div>

        @if ($ringkasanKeuangan && $ringkasanKeuangan['jumlah_periode'] > 0)
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="text-center bg-krem rounded-lg p-4">
                    <div class="text-xs text-gray-600 mb-1">Total Pemasukan</div>
                    <div class="text-lg font-poppins font-bold text-hijau-daun">
                        Rp {{ number_format($ringkasanKeuangan['total_pemasukan'], 0, ',', '.') }}
                    </div>
                </div>
                <div class="text-center bg-krem rounded-lg p-4">
                    <div class="text-xs text-gray-600 mb-1">Total Pengeluaran</div>
                    <div class="text-lg font-poppins font-bold text-cokelat-tanah">
                        Rp {{ number_format($ringkasanKeuangan['total_pengeluaran'], 0, ',', '.') }}
                    </div>
                </div>
                <div class="text-center bg-krem rounded-lg p-4">
                    <div class="text-xs text-gray-600 mb-1">Saldo Terakhir</div>
                    <div class="text-lg font-poppins font-bold
                        {{ $ringkasanKeuangan['saldo_terakhir'] >= 0 ? 'text-hijau-daun' : 'text-red-600' }}">
                        Rp {{ number_format($ringkasanKeuangan['saldo_terakhir'], 0, ',', '.') }}
                    </div>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-3 italic">
                * Berdasarkan {{ $ringkasanKeuangan['jumlah_periode'] }} periode laporan yang dipublikasikan.
            </p>
        @else
            <p class="text-gray-500 italic">Belum ada laporan keuangan yang dipublikasikan.</p>
        @endif
    </section>

</div>
@endsection