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
        Schema::create('detail_peminjamans', function (Blueprint $table) {
            $table->increments('id_detail');
            $table->unsignedInteger('id_peminjaman');
            $table->unsignedInteger('id_buku');
            $table->enum('status_buku', ['dipinjam', 'dikembalikan', 'hilang'])->default('dipinjam')->index();

            $table->unique(['id_peminjaman', 'id_buku'], 'uq_peminjaman_buku');

            $table->foreign('id_peminjaman')
                ->references('id_peminjaman')->on('peminjamans')
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
        Schema::dropIfExists('detail_peminjamans');
    }
};
