<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Pengembalian extends Model
{
    protected $table = 'pengembalians';
    protected $primaryKey = 'id_pengembalian';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_peminjaman',
        'id_detail',
        'id_petugas',
        'tanggal_kembali',
        'terlambat_hari',
        'denda',
        'kondisi_buku',
        'keterangan'
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kembali' => 'datetime',
            'terlambat_hari' => 'integer',
            'denda' => 'decimal:2',
        ];
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function detailPeminjaman()
    {
        return $this->belongsTo(DetailPeminjaman::class, 'id_detail', 'id_detail');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    public function dendas()
    {
        return $this->hasMany(Denda::class, 'id_pengembalian', 'id_pengembalian');
    }

    public function scopeTerlambat(Builder $query)
    {
        return $query->where('terlambat_hari', '>', 0);
    }
}
