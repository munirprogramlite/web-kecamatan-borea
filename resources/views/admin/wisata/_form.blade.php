<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    @if (auth()->user()->desa_id === null)
        <div>
            <label class="block text-sm font-medium mb-1">Desa <span class="text-red-500">*</span></label>
            <select name="desa_id" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
                <option value="">-- Pilih Desa --</option>
                @foreach ($desa as $d)
                    <option value="{{ $d->id }}"
                        {{ old('desa_id', $wisata?->desa_id ?? '') == $d->id ? 'selected' : '' }}>
                        {{ $d->nama }}
                    </option>
                @endforeach
            </select>
            @error('desa_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
    @else
        <input type="hidden" name="desa_id" value="{{ auth()->user()->desa_id }}">
    @endif

    <div>
        <label class="block text-sm font-medium mb-1">Nama Wisata <span class="text-red-500">*</span></label>
        <input type="text" name="nama" required
               value="{{ old('nama', $wisata?->nama ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
        @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Foto (1 gambar, maks 2MB)</label>
        <input type="file" name="foto" accept="image/*"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-hijau-daun">
        @error('foto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

        @if (! empty($wisata?->foto))
            <div class="mt-2">
                <img src="{{ asset('storage/' . $wisata->foto) }}"
                     class="w-24 h-24 object-cover rounded-lg border" alt="Foto saat ini">
                <p class="text-xs text-gray-500 mt-1">Foto saat ini. Upload baru untuk mengganti.</p>
            </div>
        @endif
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Status</label>
        <select name="status"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
            <option value="tayang"   {{ old('status', $wisata?->status ?? 'tayang') === 'tayang' ? 'selected' : '' }}>Tayang</option>
            <option value="nonaktif" {{ old('status', $wisata?->status ?? '') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Deskripsi</label>
        <textarea name="deskripsi" rows="3"
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">{{ old('deskripsi', $wisata?->deskripsi ?? '') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Harga Tiket</label>
        <input type="text" name="harga_tiket" placeholder="Contoh: Rp 10.000 atau Gratis"
               value="{{ old('harga_tiket', $wisata?->harga_tiket ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Jam Buka</label>
        <input type="text" name="jam_buka" placeholder="Contoh: 07.00 - 18.00"
               value="{{ old('jam_buka', $wisata?->jam_buka ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Alamat</label>
        <input type="text" name="alamat"
               value="{{ old('alamat', $wisata?->alamat ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Kontak</label>
        <input type="text" name="kontak" placeholder="0812-xxxx-xxxx"
               value="{{ old('kontak', $wisata?->kontak ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
    </div>

</div>