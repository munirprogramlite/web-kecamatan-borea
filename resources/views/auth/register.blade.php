<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-hijau-daun/10 text-3xl mb-3">
            🌿
        </div>
        <h1 class="text-2xl font-poppins font-bold text-hijau-daun">Daftar Akun Baru</h1>
        <p class="text-sm text-gray-500 mt-1">Gratis, hanya butuh 1 menit.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Nama Lengkap -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-sm font-medium text-gray-700" />
            <x-text-input id="name"
                          class="block mt-1 w-full rounded-lg border-gray-300 focus:border-hijau-daun focus:ring-hijau-daun"
                          type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                          placeholder="Contoh: Budi Santoso" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Nama Akun -->
        <div>
            <x-input-label for="nama_akun" :value="__('Nama Akun')" class="text-sm font-medium text-gray-700" />
            <x-text-input id="nama_akun"
                          class="block mt-1 w-full rounded-lg border-gray-300 focus:border-hijau-daun focus:ring-hijau-daun"
                          type="text" name="nama_akun" :value="old('nama_akun')" required
                          placeholder="Contoh: budi123" />
            <p class="text-xs text-gray-500 mt-1">Nama ini akan tampil saat kamu berkomentar.</p>
            <x-input-error :messages="$errors->get('nama_akun')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700" />
            <x-text-input id="email"
                          class="block mt-1 w-full rounded-lg border-gray-300 focus:border-hijau-daun focus:ring-hijau-daun"
                          type="email" name="email" :value="old('email')" required autocomplete="username"
                          placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-gray-700" />
            <x-text-input id="password"
                          class="block mt-1 w-full rounded-lg border-gray-300 focus:border-hijau-daun focus:ring-hijau-daun"
                          type="password" name="password" required autocomplete="new-password"
                          placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Konfirmasi Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-sm font-medium text-gray-700" />
            <x-text-input id="password_confirmation"
                          class="block mt-1 w-full rounded-lg border-gray-300 focus:border-hijau-daun focus:ring-hijau-daun"
                          type="password" name="password_confirmation" required autocomplete="new-password"
                          placeholder="Ulangi password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Tombol Daftar -->
        <button type="submit"
                class="w-full bg-hijau-daun text-white py-2.5 rounded-lg font-semibold hover:bg-hijau-daun/90 transition">
            Daftar
        </button>

        <!-- Link ke Login -->
        <div class="text-center text-sm text-gray-600 pt-2 border-t">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-hijau-daun font-semibold hover:underline">
                Masuk di sini
            </a>
        </div>
    </form>
</x-guest-layout>