<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua user.
     * Diakses oleh admin & petugas (dijaga middleware di route).
     */
    public function index()
    {
        $users = User::orderBy('id')->get();

        return view('users.index', compact('users'));
    }

    // Menampilkan form tambah user
    public function create()
    {
        // Role yang login dipakai view untuk menentukan tampil/tidaknya pilihan role
        $role = auth()->user()->role;

        return view('users.create', compact('role'));
    }

    /**
     * Menyimpan user baru.
     * Admin bebas memilih role, petugas DIPAKSA membuat customer
     * agar tidak bisa membuat admin/petugas sendiri.
     */
    public function store(Request $request)
    {
        $isAdmin = auth()->user()->role == 'admin';

        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            // Field role hanya wajib & valid untuk admin
            'role' => $isAdmin ? 'required|in:admin,petugas,customer' : 'nullable',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // Petugas selalu customer, admin sesuai pilihan
            'role' => $isAdmin ? $request->role : 'customer',
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    // Menampilkan detail satu user (khusus admin)
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // Menampilkan form edit user (khusus admin)
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Memperbarui data user (khusus admin).
     * Password hanya diganti jika kolom password diisi.
     */
    public function update(Request $request, User $user)
    {
        // unique mengabaikan id user yang sedang diedit agar email lama tetap valid
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'role' => 'required|in:admin,petugas,customer',
        ]);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Ganti password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    // Menghapus user (khusus admin)
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}