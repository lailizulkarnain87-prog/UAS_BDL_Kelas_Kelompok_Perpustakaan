<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Petugas extends Model
{
    protected $table = 'petugas';
    protected $primaryKey = 'id_petugas';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'kode_petugas',
        'nama_petugas',
        'username',
        'password_hash',
        'jabatan',
        'no_telepon'
    ];

    protected $hidden = [
        'password_hash',
    ];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_petugas', 'id_petugas');
    }

    public function pengembalians()
    {
        return $this->hasMany(Pengembalian::class, 'id_petugas', 'id_petugas');
    }

    public function pembayaranDendas()
    {
        return $this->hasMany(PembayaranDenda::class, 'id_petugas', 'id_petugas');
    }

    public function dendas()
    {
        return $this->hasMany(Denda::class, 'created_by', 'id_petugas');
    }

    public function riwayatStatusDendas()
    {
        return $this->hasMany(RiwayatStatusDenda::class, 'diubah_oleh', 'id_petugas');
    }

    public function scopePustakawan(Builder $query)
    {
        return $query->where('jabatan', 'Pustakawan');
    }
}
