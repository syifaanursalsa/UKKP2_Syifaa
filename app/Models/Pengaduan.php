<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $table = 'pengaduan';

    // Hanya satu fillable yang memuat semua kolom yang boleh diisi
    protected $fillable = [
        'user_id', 
        'kategori_id', 
        'pengaduan', 
        'foto', 
        'status',
    ];

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Relasi ke User (satu pengaduan dimiliki oleh satu user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}