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
            $table->increments('id_buku');
            $table->string('isbn', 20)->unique();
            $table->string('judul', 200)->index();
            $table->string('pengarang', 100);
            $table->unsignedInteger('id_kategori');
            $table->unsignedInteger('id_penerbit');
            $table->unsignedInteger('id_rak');
            $table->year('tahun_terbit')->nullable();
            $table->string('edisi', 20)->nullable();
            $table->integer('jumlah_halaman')->nullable();
            $table->integer('stok_total')->default(1);
            $table->integer('stok_tersedia')->default(0);
            $table->string('bahasa', 30)->default('Indonesia');
            $table->text('sinopsis')->nullable();

            $table->foreign('id_kategori')
                ->references('id_kategori')->on('kategoris')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_penerbit')
                ->references('id_penerbit')->on('penerbits')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_rak')
                ->references('id_rak')->on('raks')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
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
