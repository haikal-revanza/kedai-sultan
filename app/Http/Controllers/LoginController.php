<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login'); // Pastikan file auth.login sudah ada
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Autentikasi
        if (Auth::attempt($credentials)) {
            // Periksa apakah role sesuai dengan pilihan
            if (Auth::user()->role->role_name !== $request->role) {
                Auth::logout();
                return back()->withErrors(['role' => 'Role tidak sesuai!']);
            }

            // Redirect ke dashboard sesuai role
            return redirect()->route(Auth::user()->role->role_name . '.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
