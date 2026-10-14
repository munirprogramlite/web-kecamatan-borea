<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'nama_akun' => ['required', 'string', 'max:255', 'unique:users,nama_akun', 'alpha_dash'],
            'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password'  => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'      => $request->name,
            'nama_akun' => $request->nama_akun,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'peran'     => 'warga',
            'desa_id'   => null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}