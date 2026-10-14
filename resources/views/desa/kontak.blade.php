@extends('layouts.public')

@section('title', 'Kontak Desa ' . $desa->nama)

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    @include('partials.back-link', ['desa' => $desa])

    <h1 class="text-3xl font-poppins font-bold text-hijau-daun mb-2">
        Kontak Balai Desa {{ $desa->nama }}
    </h1>
    <p class="text-gray-600 mb-8">
        Hubungi kami untuk informasi layanan, pengaduan, atau aspirasi warga.
    </p>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        {{-- KIRI: Info Kontak + Jam Layanan --}}
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="font-poppins font-semibold text-lg mb-4 text-cokelat-tanah">Informasi Kontak</h2>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-gray-500">Alamat Balai Desa</dt>
                        <dd class="font-semibold">{{ $desa->alamat_balai ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Telepon</dt>
                        <dd class="font-semibold">
                            @if ($desa->telepon)
                                <a href="tel:{{ preg_replace('/[^0-9]/', '', $desa->telepon) }}"
                                   class="text-hijau-daun hover:underline">
                                    {{ $desa->telepon }}
                                </a>
                            @else
                                -
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">WhatsApp</dt>
                        <dd class="font-semibold">
                            @if ($desa->telepon)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $desa->telepon) }}"
                                   target="_blank"
                                   class="inline-block mt-1 bg-hijau-daun text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-hijau-daun/90">
                                    Chat via WhatsApp
                                </a>
                            @else
                                -
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="font-poppins font-semibold text-lg mb-4 text-cokelat-tanah">Jam Layanan</h2>
                <ul class="text-sm divide-y">
                    @php
                        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                    @endphp
                    @foreach ($hari as $h)
                        <li class="flex justify-between py-2">
                            <span class="text-gray-700">{{ $h }}</span>
                            <span class="font-semibold
                                {{ in_array($h, ['Sabtu', 'Minggu']) ? 'text-gray-400' : 'text-hijau-daun' }}">
                                {{ in_array($h, ['Sabtu', 'Minggu']) ? 'Tutup' : '08.00 - 15.00' }}
                            </span>
                        </li>
                    @endforeach
                </ul>
                <p class="text-xs text-gray-500 mt-3 italic">
                    * Hari libur nasional: tutup.
                </p>
            </div>
        </div>

        {{-- KANAN: Google Maps --}}
        <div class="bg-white rounded-xl shadow p-6 flex flex-col">
            <h2 class="font-poppins font-semibold text-lg mb-4 text-cokelat-tanah">Lokasi Balai Desa</h2>
            <div class="flex-1 rounded-lg overflow-hidden border border-gray-200">
                <iframe
                    src="https://www.google.com/maps?q={{ urlencode($desa->alamat_balai ?? $desa->nama) }}&output=embed"
                    class="w-full h-full min-h-[320px]"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <p class="text-xs text-gray-500 mt-3">
                Peta bersifat perkiraan berdasarkan alamat balai desa.
            </p>
        </div>

    </div>

    {{-- Form Aspirasi --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="font-poppins font-semibold text-lg mb-2 text-cokelat-tanah">Sampaikan Aspirasi atau Pertanyaan</h2>
        <p class="text-sm text-gray-600 mb-4">
            Isi form di bawah, pesan akan diteruskan ke WhatsApp Balai Desa {{ $desa->nama }}.
        </p>

        @php
            $noWa = preg_replace('/[^0-9]/', '', $desa->telepon ?? '');
        @endphp

        @if ($noWa)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <label class="block text-gray-700 mb-1 font-medium">Nama</label>
                    <input type="text" id="namaPengirim" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
                </div>
                <div>
                    <label class="block text-gray-700 mb-1 font-medium">No. HP (opsional)</label>
                    <input type="text" id="noPengirim"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700 mb-1 font-medium">Pesan / Aspirasi</label>
                    <textarea id="pesanPengirim" rows="4" required
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun"></textarea>
                </div>
                <div class="md:col-span-2">
                    <button type="button" onclick="kirimAspirasi()"
                            class="bg-hijau-daun text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-hijau-daun/90">
                        Kirim via WhatsApp
                    </button>
                </div>
            </div>

            <script>
                function kirimAspirasi() {
                    const nama = document.getElementById('namaPengirim').value.trim();
                    const no = document.getElementById('noPengirim').value.trim();
                    const pesan = document.getElementById('pesanPengirim').value.trim();
                    if (!nama || !pesan) {
                        alert('Nama dan pesan wajib diisi.');
                        return;
                    }
                    const teks = `Halo Balai Desa {{ $desa->nama }}, saya ${nama}` +
                                 (no ? ` (${no})` : '') +
                                 `.\n\n${pesan}`;
                    window.open(`https://wa.me/{{ $noWa }}?text=${encodeURIComponent(teks)}`, '_blank');
                }
            </script>
        @else
            <p class="text-gray-500 italic">Nomor kontak belum tersedia.</p>
        @endif
    </div>

</div>
@endsection