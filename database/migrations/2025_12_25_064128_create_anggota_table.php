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
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            $table->string('kode_anggota')->unique();
            $table->string('nama');
            $table->string('nomor_identitas')->unique();
            $table->string('email')->unique();
            $table->string('telepon');
            $table->text('alamat');
            $table->string('foto')->nullable();
            $table->enum('status', ['aktif', 'nonaktif', 'suspend'])->default('aktif');
            $table->date('tanggal_bergabung');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};
