<?php

namespace App\Http\Controllers\AuthController;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(AuthRequest $request) {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'email tidak ditemukan atau salah',
            'password' => 'password salah',
        ]);

    }

    public function logout(AuthRequest $request) {
        Auth::logout();
        $request ->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
