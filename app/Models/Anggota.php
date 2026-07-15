<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Anggota extends Model
{
    protected $table = 'anggotas';
    protected $primaryKey = 'id_anggota';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'kode_anggota',
        'nama_lengkap',
        'email',
        'no_telepon',
        'alamat',
        'tanggal_daftar',
        'status_anggota'
    ];

    protected function casts(): array
    {
        return [
            'tanggal_daftar' => 'date',
        ];
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_anggota', 'id_anggota');
    }

    public function reservasis()
    {
        return $this->hasMany(Reservasi::class, 'id_anggota', 'id_anggota');
    }

    public function dendas()
    {
        return $this->hasMany(Denda::class, 'id_anggota', 'id_anggota');
    }

    public function scopeAktif(Builder $query)
    {
        return $query->where('status_anggota', 'aktif');
    }
}
