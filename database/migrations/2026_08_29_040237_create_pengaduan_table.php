<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel pengaduan.
     */
    public function up(): void
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            // Pengaduan milik user mana (jika user dihapus, pengaduannya ikut terhapus)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('pengaduan');
            $table->string('foto')->nullable();
            // Status alur penanganan pengaduan
            $table->enum('status', ['menunggu', 'diproses', 'selesai'])->default('menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};