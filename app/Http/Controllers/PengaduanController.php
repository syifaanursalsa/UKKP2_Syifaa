<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kategori;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    // ========== KHUSUS CUSTOMER ==========

    public function index()
    {
        $pengaduan = auth()->user()->pengaduan()->with('kategori')->latest()->get();
        return view('pengaduan.index', compact('pengaduan'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('pengaduan.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'pengaduan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('foto', 'public');
        }

        auth()->user()->pengaduan()->create([
            'kategori_id' => $request->kategori_id,
            'pengaduan' => $request->pengaduan,
            'foto' => $foto,
            'status' => 'menunggu',
        ]);

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dikirim.');
    }

    public function edit($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if ($pengaduan->user_id != auth()->user()->id || $pengaduan->status != 'menunggu') {
            abort(403);
        }

        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('pengaduan.edit', compact('pengaduan', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if ($pengaduan->user_id != auth()->user()->id || $pengaduan->status != 'menunggu') {
            abort(403);
        }

        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'pengaduan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pengaduan->kategori_id = $request->kategori_id;
        $pengaduan->pengaduan = $request->pengaduan;

        if ($request->hasFile('foto')) {
            $pengaduan->foto = $request->file('foto')->store('foto', 'public');
        }

        $pengaduan->save();

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil diperbarui.');
    }

    // ========== KHUSUS ADMIN & PETUGAS (KELOLA) ==========

   public function kelolaIndex()
{
    $pengaduan = Pengaduan::with(['user', 'kategori'])->latest()->get();
    return view('pengaduan.kelola', compact('pengaduan')); // Pastikan ini cocok dengan nama file view kamu!
}

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->status = $request->status;
        $pengaduan->save();

        return redirect()->route('kelola.pengaduan')->with('success', 'Status pengaduan berhasil diperbarui.');
    }
}