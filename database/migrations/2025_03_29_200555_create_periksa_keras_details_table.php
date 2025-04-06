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
        Schema::create('periksa_keras_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periksa_keras_id')->constrained('periksa_keras')->onDelete('cascade');
            $table->integer('meja_ke');
            $table->foreignId('perkeras_id')->constrained('perkeras')->onDelete('cascade');
            $table->enum('kondisi_fisik', ['Baik', 'Buruk']);
            $table->enum('kondisi_fungsional', ['Baik', 'Buruk']);
            $table->string('keterangan')->nullable();
            // $table->enum('status', ['Perangkat Diganti', 'Sedang Perbaikan', 'Proses Pembaruan'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periksa_keras_details');
    }
};
