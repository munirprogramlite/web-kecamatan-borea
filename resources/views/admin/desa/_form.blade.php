<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Nama Desa <span class="text-red-500">*</span></label>
        <input type="text" name="nama" required placeholder="Contoh: Sukamaju"
               value="{{ old('nama', $desa?->nama ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
        @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Sambutan Kepala Desa</label>
        <textarea name="sambutan" rows="3" placeholder="Kalimat sambutan singkat untuk beranda desa..."
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">{{ old('sambutan', $desa?->sambutan ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Sejarah Singkat</label>
        <textarea name="sejarah" rows="4"
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">{{ old('sejarah', $desa?->sejarah ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Letak Geografis</label>
        <textarea name="letak_geografis" rows="3"
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">{{ old('letak_geografis', $desa?->letak_geografis ?? '') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Telepon</label>
        <input type="text" name="telepon" placeholder="0812-xxxx-xxxx"
               value="{{ old('telepon', $desa?->telepon ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Jam Layanan</label>
        <input type="text" name="jam_layanan" placeholder="Senin - Jumat, 08.00 - 15.00 WIB"
               value="{{ old('jam_layanan', $desa?->jam_layanan ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Alamat Balai Desa</label>
        <input type="text" name="alamat_balai"
               value="{{ old('alamat_balai', $desa?->alamat_balai ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
    </div>

</div>