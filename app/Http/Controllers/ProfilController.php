<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    /**
     * Menampilkan form profil user yang sedang login.
     * Tidak ada parameter ID di URL, sehingga setiap user hanya bisa
     * melihat profilnya sendiri.
     */
    public function index()
    {
        $user = auth()->user();

        return view('profil.index', compact('user'));
    }

    /**
     * Menyimpan perubahan profil user yang sedang login.
     * Password opsional (boleh kosong kalau tidak ingin diganti).
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:100',
            // Email unik, kecuali email user itu sendiri (ignore id user)
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        // Siapkan data yang akan disimpan
        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
        ];

        // Jika password diisi, hash dan tambahkan ke data
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Update user yang sedang login
        $user->update($data);

        return redirect()->route('profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}