@extends('layouts.app')

@section('title', 'Edit Pengaduan')

@section('content')
    <h5 class="mb-4">Edit Pengaduan</h5>

    <div class="card col-md-7">
        <div class="card-body">
            <form action="{{ route('pengaduan.update', $pengaduan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Kategori</label>
                    <select name="kategori_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $k)
                            <option value="{{ $k->id }}" @selected(old('kategori_id', $pengaduan->kategori_id) == $k->id)>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Isi Pengaduan</label>
                    <textarea name="pengaduan" rows="5" class="form-control" required>{{ old('pengaduan', $pengaduan->pengaduan) }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-semibold">Foto Bukti (isi hanya jika ingin mengganti)</label>
                    @if ($pengaduan->foto)
                        <div class="mb-2">
                            <img src="{{ Storage::url($pengaduan->foto) }}" class="rounded" style="max-height: 150px; object-fit: cover;">
                        </div>
                    @endif
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>
                <button class="btn btn-sm text-white px-3" style="background: #14b8a6;">Simpan Perubahan</button>
                <a href="{{ route('pengaduan.index') }}" class="btn btn-sm btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection