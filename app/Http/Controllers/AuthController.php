<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function formRegistrasi()
    {
        return view('auth.registrasi');
    }

    public function registrasi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Proses penyimpanan pengguna baru menggunakan Eloquent ORM
        $user = User::registrasi($validator->validated());
        $token = $user->createToken('LaravelPassportToken')->accessToken;

        // Menyimpan pesan sukses ke session
        session()->flash('success', 'Akun Anda berhasil dibuat! Silakan login.');


        return redirect()->route('auth.registrasi.form'); // atau sesuai dengan halaman tujuan Anda
    }

    public function formLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cek kredensial pengguna
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Login berhasil, arahkan ke halaman utama
            return redirect()->route('home.index');
        }

        // Jika login gagal, kembalikan dengan pesan error
        return redirect()->back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function logout(Request $request)
    {
        // Log out the user
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the session token
        $request->session()->regenerateToken();

        // Redirect to the login page or home page
        return redirect()->route('auth.login.form')->with('success', 'You have been logged out successfully.');
    }
}
