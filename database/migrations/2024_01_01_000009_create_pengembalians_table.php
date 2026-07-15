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
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->increments('id_pengembalian');
            $table->unsignedInteger('id_peminjaman');
            $table->unsignedInteger('id_detail')->unique();
            $table->unsignedInteger('id_petugas');
            $table->datetime('tanggal_kembali')->default(DB::raw('CURRENT_TIMESTAMP'))->index();
            $table->integer('terlambat_hari')->default(0);
            $table->decimal('denda', 10, 2)->default(0);
            $table->enum('kondisi_buku', ['baik', 'rusak', 'hilang'])->default('baik');
            $table->text('keterangan')->nullable();

            $table->foreign('id_peminjaman')
                ->references('id_peminjaman')->on('peminjamans')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_detail')
                ->references('id_detail')->on('detail_peminjamans')
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
        Schema::dropIfExists('pengembalians');
    }
};
