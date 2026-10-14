<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-hijau-daun/10 text-3xl mb-3">
            🌿
        </div>
        <h1 class="text-2xl font-poppins font-bold text-hijau-daun">Masuk ke Borea</h1>
        <p class="text-sm text-gray-500 mt-1">Selamat datang kembali!</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700" />
            <x-text-input id="email"
                          class="block mt-1 w-full rounded-lg border-gray-300 focus:border-hijau-daun focus:ring-hijau-daun"
                          type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-gray-700" />
            <x-text-input id="password"
                          class="block mt-1 w-full rounded-lg border-gray-300 focus:border-hijau-daun focus:ring-hijau-daun"
                          type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember + Forgot -->
        <div class="flex items-center justify-between text-sm">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded border-gray-300 text-hijau-daun shadow-sm focus:ring-hijau-daun" name="remember">
                <span class="ms-2 text-gray-600">{{ __('Ingat saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-hijau-daun hover:underline text-xs" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <!-- Tombol Masuk -->
        <button type="submit"
                class="w-full bg-hijau-daun text-white py-2.5 rounded-lg font-semibold hover:bg-hijau-daun/90 transition">
            Masuk
        </button>

        <!-- Link ke Register -->
        <div class="text-center text-sm text-gray-600 pt-2 border-t">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-hijau-daun font-semibold hover:underline">
                Daftar sekarang
            </a>
        </div>
    </form>
</x-guest-layout>