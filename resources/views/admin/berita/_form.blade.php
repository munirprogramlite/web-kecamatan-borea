<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    @if (auth()->user()->desa_id === null)
        <div>
            <label class="block text-sm font-medium mb-1">Desa <span class="text-red-500">*</span></label>
            <select name="desa_id" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
                <option value="">-- Pilih Desa --</option>
                @foreach ($desa as $d)
                    <option value="{{ $d->id }}"
                        {{ old('desa_id', $berita?->desa_id ?? '') == $d->id ? 'selected' : '' }}>
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
        <label class="block text-sm font-medium mb-1">Tanggal Tayang <span class="text-red-500">*</span></label>
        <input type="date" name="tanggal_tayang" required
               value="{{ old('tanggal_tayang', $berita?->tanggal_tayang?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
        @error('tanggal_tayang') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Judul <span class="text-red-500">*</span></label>
        <input type="text" name="judul" required
               value="{{ old('judul', $berita?->judul ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
        @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Isi Berita <span class="text-red-500">*</span></label>
        <textarea name="isi" rows="8" required
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">{{ old('isi', $berita?->isi ?? '') }}</textarea>
        @error('isi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

</div>