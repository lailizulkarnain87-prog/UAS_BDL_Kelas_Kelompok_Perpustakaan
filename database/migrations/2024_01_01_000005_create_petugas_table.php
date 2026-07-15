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
        Schema::create('petugas', function (Blueprint $table) {
            $table->increments('id_petugas');
            $table->string('kode_petugas', 10)->unique();
            $table->string('nama_petugas', 100);
            $table->string('username', 50)->unique();
            $table->string('password_hash', 255);
            $table->string('jabatan', 50)->nullable();
            $table->string('no_telepon', 15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petugas');
    }
};
