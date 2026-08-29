<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    /**
     * Customer: menampilkan daftar pengaduan MILIK SENDIRI.
     * Query dimulai dari user yang login, jadi tidak mungkin
     * melihat pengaduan customer lain.
     */
    public function index()
    {
        $pengaduan = auth()->user()->pengaduan()->latest()->get();

        return view('pengaduan.index', compact('pengaduan'));
    }

    // Customer: menampilkan form buat pengaduan
    public function create()
    {
        return view('pengaduan.create');
    }

    /**
     * Customer: menyimpan pengaduan baru.
     * user_id diambil dari user yang login (bukan dari form)
     * agar tidak bisa membuat pengaduan atas nama orang lain.
     */
    public function store(Request $request)
    {
        // Validasi: isi wajib, foto opsional berupa gambar max 2MB
        $request->validate([
            'pengaduan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $foto = null;

        // Jika ada foto diupload, simpan ke storage/app/public/foto
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('foto', 'public');
        }

        // Simpan pengaduan terhubung ke user yang login
        auth()->user()->pengaduan()->create([
            'pengaduan' => $request->pengaduan,
            'foto' => $foto,
            'status' => 'menunggu', // pengaduan baru selalu "menunggu"
        ]);

        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil dikirim.');
    }

    /**
     * Customer: melihat detail satu pengaduan.
     * Dicek kepemilikannya: jika bukan miliknya, tolak 403.
     */
    public function show(Pengaduan $pengaduan)
    {
        if ($pengaduan->user_id !== auth()->id()) {
            abort(403, 'Anda tidak dapat melihat pengaduan orang lain.');
        }

        return view('pengaduan.show', compact('pengaduan'));
    }

    /**
     * Admin & petugas: menampilkan SEMUA pengaduan
     * lengkap dengan nama customer pemiliknya.
     */
    public function kelola()
    {
        $pengaduan = Pengaduan::with('user')->latest()->get();

        return view('pengaduan.kelola', compact('pengaduan'));
    }

    /**
     * Admin & petugas: mengubah status pengaduan
     * (menunggu → diproses → selesai).
     */
    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai',
        ]);

        $pengaduan->update(['status' => $request->status]);

        return redirect()->route('kelola.pengaduan')
            ->with('success', 'Status pengaduan diperbarui.');
    }
}