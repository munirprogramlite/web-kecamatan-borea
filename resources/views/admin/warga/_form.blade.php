<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    @if (auth()->user()->desa_id === null)
        <div>
            <label class="block text-sm font-medium mb-1">Desa <span class="text-red-500">*</span></label>
            <select name="desa_id" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
                <option value="">-- Pilih Desa --</option>
                @foreach ($desa as $d)
                    <option value="{{ $d->id }}"
                        {{ old('desa_id', $warga?->desa_id ?? '') == $d->id ? 'selected' : '' }}>
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
        <input type="text" name="periode" required placeholder="Contoh: 2026"
               value="{{ old('periode', $warga?->periode ?? date('Y')) }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
        @error('periode') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    @php
        $fields = [
            ['name' => 'jumlah_kk',        'label' => 'Jumlah KK'],
            ['name' => 'jumlah_laki',      'label' => 'Jumlah Laki-laki'],
            ['name' => 'jumlah_perempuan', 'label' => 'Jumlah Perempuan'],
            ['name' => 'usia_0_14',        'label' => 'Usia 0 - 14'],
            ['name' => 'usia_15_64',       'label' => 'Usia 15 - 64'],
            ['name' => 'usia_65_plus',     'label' => 'Usia 65+'],
        ];
    @endphp

    @foreach ($fields as $f)
        <div>
            <label class="block text-sm font-medium mb-1">{{ $f['label'] }} <span class="text-red-500">*</span></label>
            <input type="number" name="{{ $f['name'] }}" required min="0"
                   value="{{ old($f['name'], $warga?->{$f['name']} ?? 0) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-hijau-daun">
            @error($f['name']) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
    @endforeach

</div>