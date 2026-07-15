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
        Schema::create('dendas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_pengembalian')->nullable();
            $table->unsignedInteger('id_anggota');
            $table->decimal('total_denda', 12, 2);
            $table->decimal('sisa_denda', 12, 2);
            $table->string('status_denda', 20)->default('pending')->index();
            $table->date('tanggal_dikenakan')->index();
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->text('alasan_denda')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamps();

            $table->index('id_anggota');

            $table->foreign('id_pengembalian')
                ->references('id_pengembalian')->on('pengembalians')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_anggota')
                ->references('id_anggota')->on('anggotas')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('created_by')
                ->references('id_petugas')->on('petugas')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dendas');
    }
};
