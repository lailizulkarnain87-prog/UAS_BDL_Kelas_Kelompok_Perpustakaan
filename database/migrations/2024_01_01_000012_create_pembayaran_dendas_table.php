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
        Schema::create('pembayaran_dendas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_denda')->index();
            $table->unsignedInteger('id_petugas')->index();
            $table->decimal('jumlah_bayar', 12, 2);
            $table->datetime('tanggal_bayar')->default(DB::raw('CURRENT_TIMESTAMP'))->index();
            $table->string('metode_bayar', 20)->default('tunai');
            $table->string('bukti_bayar', 255)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_denda')
                ->references('id')->on('dendas')
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
        Schema::dropIfExists('pembayaran_dendas');
    }
};
