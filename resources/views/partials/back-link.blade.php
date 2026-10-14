@props(['desa', 'label' => 'Kembali ke Beranda Desa'])

<a href="{{ route('desa.beranda', $desa->slug) }}"
   class="inline-flex items-center gap-1 text-sm text-hijau-daun font-semibold hover:underline mb-6">
    <span class="text-base">&larr;</span>
    <span>{{ $label }}</span>
</a>