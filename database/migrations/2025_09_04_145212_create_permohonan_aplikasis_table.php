<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('permohonan_aplikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // pemohon
            $table->string('program_studi');
            $table->string('fakultas');
            $table->json('daftar_software'); // simpan tabel software dalam bentuk JSON
            $table->date('tgl_dibutuhkan')->nullable();
            $table->text('alasan');

            // Balasan Admin
            $table->enum('status', ['menunggu','diproses','disetujui','ditolak'])->default('menunggu');
            $table->string('nomor_surat_balasan')->nullable();
            $table->date('tanggal_balasan')->nullable();
            $table->text('isi_balasan')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonan_aplikasi');
    }
};
