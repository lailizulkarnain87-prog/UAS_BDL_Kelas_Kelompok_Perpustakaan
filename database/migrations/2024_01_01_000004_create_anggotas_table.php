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
        Schema::create('anggotas', function (Blueprint $table) {
            $table->increments('id_anggota');
            $table->string('kode_anggota', 15)->unique();
            $table->string('nama_lengkap', 100)->index();
            $table->string('email', 100)->unique();
            $table->string('no_telepon', 15)->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_daftar')->default(DB::raw('(CURDATE())'));
            $table->enum('status_anggota', ['aktif', 'nonaktif'])->default('aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};
