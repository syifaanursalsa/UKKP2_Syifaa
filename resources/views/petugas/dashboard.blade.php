@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
    <h5 class="mb-1">Selamat datang, {{ auth()->user()->nama }}</h5>
    <p class="text-muted mb-4">Ringkasan pengaduan yang perlu ditangani.</p>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm border-start border-4 border-primary">
                <div class="card-body">
                    <p class="text-muted small mb-1"><i class="bi bi-clipboard-data me-1"></i>Total Pengaduan</p>
                    <h4 class="fw-bold mb-0">{{ $totalPengaduan }}</h4>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm border-start border-4 border-warning">
                <div class="card-body">
                    <p class="text-muted small mb-1"><i class="bi bi-hourglass-split me-1"></i>Perlu Ditangani</p>
                    <h4 class="fw-bold mb-0">{{ $perluDitangani }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Daftar pengaduan terbaru --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h6 class="fw-bold mb-3">Pengaduan Terbaru</h6>

            @forelse ($pengaduanTerbaru as $p)
                <div class="border-bottom py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small text-muted">
                            {{ $p->user->nama }} &middot; {{ $p->created_at->format('d M Y') }}
                        </span>
                        {{-- Warna badge mengikuti status pengaduan --}}
                        @php
                            $badge = [
                                'menunggu' => 'text-bg-warning',
                                'diproses' => 'text-bg-primary',
                                'selesai'  => 'text-bg-success',
                            ][$p->status] ?? 'text-bg-secondary';
                        @endphp
                        <span class="badge {{ $badge }}">{{ ucfirst($p->status) }}</span>
                    </div>
                    <p class="small mb-0">{{ Str::limit($p->pengaduan, 100) }}</p>
                </div>
            @empty
                <p class="text-muted small mb-0">Belum ada pengaduan yang masuk.</p>
            @endforelse
        </div>
    </div>
@endsection