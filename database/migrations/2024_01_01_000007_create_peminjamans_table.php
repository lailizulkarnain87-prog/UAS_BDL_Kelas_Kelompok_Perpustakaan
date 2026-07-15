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
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->increments('id_peminjaman');
            $table->string('kode_peminjaman', 15)->unique();
            $table->unsignedInteger('id_anggota')->index();
            $table->unsignedInteger('id_petugas');
            $table->datetime('tanggal_pinjam')->default(DB::raw('CURRENT_TIMESTAMP'))->index();
            $table->date('tanggal_batas_kembali');
            $table->enum('status_peminjaman', ['aktif', 'selesai', 'terlambat'])->default('aktif');
            $table->integer('total_buku');

            $table->foreign('id_anggota')
                ->references('id_anggota')->on('anggotas')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_petugas')
                ->references('id_petugas')->on('petugas')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
