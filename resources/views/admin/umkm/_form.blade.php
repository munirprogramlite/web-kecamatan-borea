{{-- Form field UMKM --}}

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    @if (auth()->user()->desa_id === null)
        <div>
            <label class="block text-sm font-medium mb-1">Desa <span class="text-red-500">*</span></label>
            <select name="desa_id" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
                <option value="">-- Pilih Desa --</option>
                @foreach ($desa as $d)
                    <option value="{{ $d->id }}"
                        {{ old('desa_id', $umkm->desa_id ?? '') == $d->id ? 'selected' : '' }}>
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
        <label class="block text-sm font-medium mb-1">Nama UMKM <span class="text-red-500">*</span></label>
        <input type="text" name="nama" required
               value="{{ old('nama', $umkm->nama ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
        @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Foto (1 gambar, maks 2MB)</label>
        <input type="file" name="foto" accept="image/*"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-hijau-daun">
        @error('foto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

        @if (! empty($umkm->foto))
            <div class="mt-2">
                <img src="{{ asset('storage/' . $umkm->foto) }}"
                     class="w-24 h-24 object-cover rounded-lg border" alt="Foto saat ini">
                <p class="text-xs text-gray-500 mt-1">Foto saat ini. Upload baru untuk mengganti.</p>
            </div>
        @endif
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Status</label>
        <select name="status"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
            <option value="tayang"   {{ old('status', $umkm->status ?? 'tayang') === 'tayang'   ? 'selected' : '' }}>Tayang</option>
            <option value="nonaktif" {{ old('status', $umkm->status ?? '') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Deskripsi</label>
        <textarea name="deskripsi" rows="3"
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">{{ old('deskripsi', $umkm->deskripsi ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Menu & Harga</label>
        <textarea name="menu" rows="3" placeholder="Contoh:&#10;Soto Ayam - Rp 15.000&#10;Es Teh - Rp 5.000"
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">{{ old('menu', $umkm->menu ?? '') }}</textarea>
        <p class="text-xs text-gray-500 mt-1">Tulis satu item per baris.</p>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Alamat</label>
        <input type="text" name="alamat"
               value="{{ old('alamat', $umkm->alamat ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Kontak WhatsApp</label>
        <input type="text" name="kontak" placeholder="0812-xxxx-xxxx"
               value="{{ old('kontak', $umkm->kontak ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
    </div>

</div>