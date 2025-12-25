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
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            $table->string('judul');
            $table->string('pengarang');
            $table->string('penerbit');
            $table->string('isbn')->unique();
            $table->year('tahun_terbit');
            $table->integer('stok')->default(0);
            $table->integer('tersedia')->default(0);
            $table->string('foto_sampul')->nullable();
            $table->enum('status', ['tersedia', 'dipinjam', 'rusak', 'hilang'])->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
