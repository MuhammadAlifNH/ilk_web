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
        Schema::create('periksa_lunak_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periksa_lunak_id')->constrained('periksa_lunaks')->onDelete('cascade');
            $table->integer('meja_ke');
            $table->foreignId('perlunak_id')->constrained('perlunaks')->onDelete('cascade');
            $table->enum('kondisi_fungsional', ['Baik', 'Buruk']);
            $table->string('keterangan')->nullable();
            // $table->enum('status', ['Aplikasi Diupdate', 'Aplikasi Diperbaiki', 'Aplikasi Diganti'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periksa_lunak_details');
    }
};
