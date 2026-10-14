<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    @if (auth()->user()->desa_id === null)
        <div>
            <label class="block text-sm font-medium mb-1">Desa <span class="text-red-500">*</span></label>
            <select name="desa_id" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
                <option value="">-- Pilih Desa --</option>
                @foreach ($desa as $d)
                    <option value="{{ $d->id }}"
                        {{ old('desa_id', $laporan?->desa_id ?? '') == $d->id ? 'selected' : '' }}>
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
        <label class="block text-sm font-medium mb-1">Periode <span class="text-red-500">*</span></label>
        <input type="text" name="periode" required placeholder="Contoh: 2026-10"
               value="{{ old('periode', $laporan?->periode ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
        @error('periode') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Status</label>
        <select name="status"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
            <option value="draf"           {{ old('status', $laporan?->status ?? 'draf') === 'draf'           ? 'selected' : '' }}>Draf</option>
            <option value="dipublikasikan" {{ old('status', $laporan?->status ?? '') === 'dipublikasikan' ? 'selected' : '' }}>Dipublikasikan</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Pemasukan (Rp) <span class="text-red-500">*</span></label>
        <input type="number" name="pemasukan" required min="0" step="1000"
               value="{{ old('pemasukan', $laporan?->pemasukan ?? 0) }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
        @error('pemasukan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Pengeluaran (Rp) <span class="text-red-500">*</span></label>
        <input type="number" name="pengeluaran" required min="0" step="1000"
               value="{{ old('pengeluaran', $laporan?->pengeluaran ?? 0) }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
        @error('pengeluaran') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2 text-xs text-gray-500 italic">
        💡 Saldo akan dihitung otomatis: Pemasukan − Pengeluaran.
    </div>

</div>