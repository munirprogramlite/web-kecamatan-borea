@extends('layouts.public')

@section('title', 'Laporan Keuangan Desa ' . $desa->nama)

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    @include('partials.back-link', ['desa' => $desa])
    <h1 class="text-3xl font-poppins font-bold text-hijau-daun mb-6">Laporan Keuangan Desa {{ $desa->nama }}</h1>

    {{-- Grafik --}}
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="font-poppins font-semibold mb-4">Grafik Pemasukan & Pengeluaran</h2>
        <canvas id="chartLaporan" height="100"></canvas>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-hijau-daun text-white">
                <tr>
                    <th class="px-4 py-3 text-left">Periode</th>
                    <th class="px-4 py-3 text-right">Pemasukan</th>
                    <th class="px-4 py-3 text-right">Pengeluaran</th>
                    <th class="px-4 py-3 text-right">Saldo</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($laporan as $l)
                    <tr>
                        <td class="px-4 py-3">{{ $l->periode }}</td>
                        <td class="px-4 py-3 text-right">Rp {{ number_format($l->pemasukan, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right">Rp {{ number_format($l->pengeluaran, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right font-semibold text-hijau-daun">
                            Rp {{ number_format($l->saldo, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada laporan dipublikasikan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('chartLaporan'), {
            type: 'bar',
            data: {
                labels: @json($laporan->pluck('periode')),
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: @json($laporan->pluck('pemasukan')),
                        backgroundColor: '#2F6B4F',
                    },
                    {
                        label: 'Pengeluaran',
                        data: @json($laporan->pluck('pengeluaran')),
                        backgroundColor: '#9C6B3E',
                    },
                ]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>

</div>
@endsection