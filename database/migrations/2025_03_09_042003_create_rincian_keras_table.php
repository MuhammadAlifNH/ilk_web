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
        Schema::create('rincian_keras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemeriksaan_id')->constrained('pemeriksaans')->onDelete('cascade');
            $table->foreignId('keras_id')->constrained('perkeras')->onDelete('cascade');
            $table->enum('kondisi_fisik', ['1', '0']);
            $table->enum('kondisi_fungsional', ['1', '0']);
            $table->string('keterangan')->default(' - ');
            $table->enum('status', [' - ', 'Perangkat Diganti', 'Sedang Perbaikan', 'Proses Pembaruan'])->default(' - ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rincian_lunaks');
    }
};
