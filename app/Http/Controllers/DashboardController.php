<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Dashboard admin.
     * Menampilkan ringkasan seluruh data sistem:
     * jumlah user per role dan jumlah pengaduan.
     */
    public function admin()
    {
        $totalUser      = User::count();
        $totalCustomer  = User::where('role', 'customer')->count();
        $totalPetugas   = User::where('role', 'petugas')->count();
        $totalPengaduan = Pengaduan::count();

        return view('admin.dashboard', compact(
            'totalUser', 'totalCustomer', 'totalPetugas', 'totalPengaduan'
        ));
    }

    /**
     * Dashboard petugas.
     * Menampilkan ringkasan pengaduan yang harus ditangani
     * beserta 5 pengaduan terbaru.
     */
    public function petugas()
    {
        $totalPengaduan  = Pengaduan::count();

        // Pengaduan yang belum selesai = masih perlu ditangani
        $perluDitangani  = Pengaduan::where('status', '!=', 'selesai')->count();

        // 5 pengaduan terbaru lengkap dengan data user pemiliknya
        $pengaduanTerbaru = Pengaduan::with('user')->latest()->take(5)->get();

        return view('petugas.dashboard', compact(
            'totalPengaduan', 'perluDitangani', 'pengaduanTerbaru'
        ));
    }

    /**
     * Dashboard customer.
     * Hanya menampilkan pengaduan MILIK user yang sedang login,
     * bukan milik customer lain.
     */
    public function customer()
    {
        $totalPengaduan = auth()->user()->pengaduan()->count();

        // 5 pengaduan terbaru milik user yang login
        $pengaduanTerbaru = auth()->user()->pengaduan()->latest()->take(5)->get();

        return view('customer.dashboard', compact(
            'totalPengaduan', 'pengaduanTerbaru'
        ));
    }
}