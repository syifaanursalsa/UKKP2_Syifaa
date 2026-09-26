@extends('layouts.app')

@section('title', 'Buat Pengaduan')

@section('content')
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('pengaduan.index') }}" class="btn btn-sm btn-outline-secondary me-2">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h5 class="mb-0">Buat Pengaduan</h5>
    </div>

    <div class="card border-0 shadow-sm" style="max-width: 700px;">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger py-2 small">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- 1. KATEGORI (paling atas) --}}
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $k)
                            <option value="{{ $k->id }}" @selected(old('kategori_id') == $k->id)>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 2. ISI PENGADUAN / DESKRIPSI --}}
                <div class="mb-3">
                    <label class="form-label">Isi Pengaduan</label>
                    <textarea name="pengaduan" rows="5" class="form-control" placeholder="Tuliskan keluhanmu secara jelas..." required>{{ old('pengaduan') }}</textarea>
                </div>

                {{-- 3. FOTO BUKTI (paling bawah) --}}
                <div class="mb-4">
                    <label class="form-label">Foto Bukti (opsional)</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                    <small class="text-muted">Format JPG/PNG, maksimal 2MB.</small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send me-1"></i>Kirim Pengaduan
                </button>
            </form>
        </div>
    </div>
@endsection