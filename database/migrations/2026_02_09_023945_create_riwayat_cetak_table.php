<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::create('riwayat_cetak', function (Blueprint $table) {
        $table->id();
        $table->string('nomor_permohonan')->nullable();
        $table->string('nik')->nullable();
        $table->string('nama_lengkap');
        $table->string('tujuan');
        $table->timestamp('waktu_cetak');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_cetak');
    }
};
