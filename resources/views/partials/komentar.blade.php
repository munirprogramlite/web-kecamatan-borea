@props(['targetTipe', 'targetId', 'komentarList'])

<div class="mt-6" id="komentar-section">

    <h3 class="font-poppins font-semibold text-lg mb-4">
        Komentar ({{ $komentarList->count() }})
    </h3>

    {{-- Flash message sukses --}}
    @if (session('sukses'))
        <div class="bg-hijau-daun/10 border border-hijau-daun text-hijau-daun text-sm rounded-lg p-3 mb-4">
            {{ session('sukses') }}
        </div>
    @endif

    {{-- Form Komentar --}}
    @auth
        <form action="{{ route('komentar.store') }}" method="POST" class="mb-6">
            @csrf
            <input type="hidden" name="target_tipe" value="{{ $targetTipe }}">
            <input type="hidden" name="target_id" value="{{ $targetId }}">
            <textarea name="isi" rows="3" maxlength="500" required
                      placeholder="Tulis komentar kamu... (maks. 500 karakter)"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-hijau-daun @error('isi') border-red-500 @enderror"></textarea>
            @error('isi')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            <div class="mt-2 flex justify-end">
                <button type="submit"
                        class="bg-hijau-daun text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-hijau-daun/90">
                    Kirim Komentar
                </button>
            </div>
        </form>
    @else
        {{-- Belum login: tombol buka modal --}}
        <div class="bg-krem border border-cokelat-tanah/30 rounded-lg p-4 mb-6 text-center">
            <p class="text-sm text-gray-600 mb-3">Ingin ikut berkomentar?</p>
            <button type="button" onclick="document.getElementById('modalLogin').classList.remove('hidden')"
                    class="bg-hijau-daun text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-hijau-daun/90">
                Masuk / Daftar
            </button>
        </div>
    @endauth

    {{-- Daftar Komentar --}}
    <div class="space-y-4">
        @forelse ($komentarList as $k)
            <div class="bg-white rounded-lg border border-gray-100 p-4">
                <div class="flex justify-between items-start mb-2">
                    <div class="text-sm">
                        <span class="font-semibold text-hijau-daun">{{ $k->user->nama_akun }}</span>
                        <span class="text-gray-400 text-xs ml-2">
                            {{ $k->dibuat_pada?->diffForHumans() }}
                        </span>
                    </div>

                    @auth
                        @php
                            $bolehHapus = auth()->id() === $k->user_id
                                || (auth()->user()->peran === 'admin'
                                    && (auth()->user()->desa_id === null
                                        || auth()->user()->desa_id === ($targetTipe === 'umkm'
                                            ? \App\Models\Umkm::find($k->target_id)?->desa_id
                                            : \App\Models\Wisata::find($k->target_id)?->desa_id)));
                        @endphp

                        @if ($bolehHapus)
                            <form action="{{ route('komentar.destroy', $k) }}" method="POST"
                                  onsubmit="return confirm('Hapus komentar ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-500 hover:underline">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
                <p class="text-sm text-gray-700 whitespace-pre-line">{{ $k->isi }}</p>
            </div>
        @empty
            <p class="text-sm text-gray-500 italic text-center py-4">
                Belum ada komentar. Jadi yang pertama!
            </p>
        @endforelse
    </div>
</div>

{{-- Modal Login (hanya muncul kalau belum login) --}}
@guest
    <div id="modalLogin" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-poppins font-semibold text-lg">Masuk atau Daftar</h3>
                <button type="button" onclick="document.getElementById('modalLogin').classList.add('hidden')"
                        class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            </div>
            <p class="text-sm text-gray-600 mb-5">
                Untuk berkomentar, kamu perlu masuk dulu. Belum punya akun? Silakan daftar gratis.
            </p>
            <div class="flex gap-3">
                <a href="{{ route('login') }}"
                   class="flex-1 text-center bg-hijau-daun text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-hijau-daun/90">
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                   class="flex-1 text-center bg-cokelat-tanah text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-cokelat-tanah/90">
                    Daftar
                </a>
            </div>
        </div>
    </div>
@endguest