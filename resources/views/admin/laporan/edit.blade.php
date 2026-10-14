@extends('layouts.admin')

@section('title', 'Edit Laporan')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-poppins font-bold text-hijau-daun">Edit Laporan: {{ $laporan->periode }}</h1>
    <a href="{{ route('admin.laporan.index') }}" class="text-sm text-hijau-daun font-semibold hover:underline">
        &larr; Kembali
    </a>
</div>

<form action="{{ route('admin.laporan.update', $laporan) }}" method="POST"
      class="bg-white rounded-xl shadow p-6 space-y-5">
    @csrf
    @method('PUT')
    @include('admin.laporan._form', ['laporan' => $laporan, 'desa' => $desa])

    <div class="flex justify-end gap-3 pt-4 border-t">
        <a href="{{ route('admin.laporan.index') }}"
           class="px-4 py-2 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-100">Batal</a>
        <button type="submit"
                class="bg-hijau-daun text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-hijau-daun/90">
            Simpan Perubahan
        </button>
    </div>
</form>

@endsection