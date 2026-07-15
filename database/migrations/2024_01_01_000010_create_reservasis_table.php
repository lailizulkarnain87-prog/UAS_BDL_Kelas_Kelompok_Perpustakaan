<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservasis', function (Blueprint $table) {
            $table->increments('id_reservasi');
            $table->unsignedInteger('id_anggota');
            $table->unsignedInteger('id_buku');
            $table->datetime('tanggal_reservasi')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->date('tanggal_kedaluwarsa');
            $table->enum('status_reservasi', ['menunggu', 'tersedia', 'diklaim', 'kedaluwarsa', 'batal'])->default('menunggu');

            $table->foreign('id_anggota')
                ->references('id_anggota')->on('anggotas')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_buku')
                ->references('id_buku')->on('bukus')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};
