<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rincian_lunaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemeriksaan_id')->constrained('pemeriksaans')->onDelete('cascade');
            $table->foreignId('lunak_id')->constrained('perlunaks')->onDelete('cascade');
            $table->enum('kondisi', ['1', '0']);
            $table->string('keterangan')->default(' - ');
            $table->enum('status', [' - ', 'Aplikasi Diupdate', 'Aplikasi Diperbaiki', 'Aplikasi Diganti'])->default(' - ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rincian_keras');
    }
};
