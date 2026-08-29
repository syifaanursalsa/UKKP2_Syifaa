<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Menampilkan halaman register (khusus customer)
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Memproses login.
     * Mencocokkan email & password ke tabel users,
     * lalu mengarahkan dashboard sesuai role user.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Mencoba masuk dengan kredensial yang diisi
        if (Auth::attempt($request->only('email', 'password'))) {
            // Perbarui session agar aman dari serangan session fixation
            $request->session()->regenerate();

            // Arahkan ke dashboard sesuai role, misal: admin.dashboard
            return redirect()->route(auth()->user()->role . '.dashboard');
        }

        // Jika gagal, kembalikan ke login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Memproses pendaftaran akun baru.
     * Role selalu "customer" dan tidak ditampilkan di form,
     * sehingga pendaftar tidak bisa memilih role sendiri.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            // Password di-hash agar tidak tersimpan sebagai teks biasa
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil. Silakan login.');
    }

    /**
     * Memproses logout.
     * Menghapus session login lalu kembali ke halaman login.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}