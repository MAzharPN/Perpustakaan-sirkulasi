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
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 64);
            $table->foreignId('id_pengarang')->constrained('pengarangs');
            $table->foreignId('id_penerbit')->constrained('penerbits');
            $table->foreignId('id_kategori')->constrained('kategoris');
            $table->year('tahun_terbit');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};