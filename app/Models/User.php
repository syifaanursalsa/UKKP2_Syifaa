<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
    ];

    // Kolom yang disembunyikan saat model diubah ke JSON/array
    protected $hidden = [
        'password',
        'remember_token',
    ];

        // Satu user bisa memiliki banyak pengaduan
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class);
    }
}