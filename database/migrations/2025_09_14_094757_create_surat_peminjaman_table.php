<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('surat_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lab_id')->constrained('labs')->onDelete('cascade');
            $table->string('instansi')->nullable();
            $table->string('no_telp')->nullable();
            $table->text('uraian'); // tujuan peminjaman
            $table->integer('jumlah_orang')->nullable();
            $table->string('lama_pinjam')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['menunggu','disetujui','ditolak'])->default('menunggu');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_peminjaman');
    }
};
