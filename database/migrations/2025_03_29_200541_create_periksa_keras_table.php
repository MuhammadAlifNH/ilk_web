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
        Schema::create('periksa_keras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fakultas_id')->constrained('fakultas')->onDelete('cascade');
            $table->foreignId('lab_id')->constrained('labs')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periksa_keras');
    }
};
