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
        Schema::create('riwayat_status_dendas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_denda')->index();
            $table->string('status_sebelum', 20)->nullable();
            $table->string('status_sesudah', 20);
            $table->unsignedInteger('diubah_oleh')->nullable();
            $table->text('alasan')->nullable();
            $table->timestamps();

            $table->foreign('id_denda')
                ->references('id')->on('dendas')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('diubah_oleh')
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
        Schema::dropIfExists('riwayat_status_dendas');
    }
};
