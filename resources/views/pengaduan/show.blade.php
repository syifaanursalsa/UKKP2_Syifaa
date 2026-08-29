@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@section('content')
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('pengaduan.index') }}" class="btn btn-sm btn-outline-secondary me-2">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h5 class="mb-0">Detail Pengaduan</h5>
    </div>

    <div class="card border-0 shadow-sm" style="max-width: 700px;">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted small">{{ $pengaduan->created_at->format('d M Y') }}</span>
                @php
                    $badge = [
                        'menunggu' => 'text-bg-warning',
                        'diproses' => 'text-bg-primary',
                        'selesai' => 'text-bg-success',
                    ][$pengaduan->status] ?? 'text-bg-secondary';
                @endphp
                <span class="badge {{ $badge }}">{{ ucfirst($pengaduan->status) }}</span>
            </div>

            <p>{{ $pengaduan->pengaduan }}</p>

            {{-- Tampilkan foto bukti jika ada --}}
            @if ($pengaduan->foto)
                <img src="{{ asset('storage/' . $pengaduan->foto) }}"
                     class="img-fluid rounded" style="max-height: 300px;" alt="Foto bukti">
            @endif
        </div>
    </div>
@endsection