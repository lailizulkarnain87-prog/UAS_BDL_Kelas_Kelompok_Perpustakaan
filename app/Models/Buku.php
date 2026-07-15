<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Buku extends Model
{
    protected $table = 'bukus';
    protected $primaryKey = 'id_buku';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'isbn',
        'judul',
        'pengarang',
        'id_kategori',
        'id_penerbit',
        'id_rak',
        'tahun_terbit',
        'edisi',
        'jumlah_halaman',
        'stok_total',
        'stok_tersedia',
        'bahasa',
        'sinopsis'
    ];

    protected function casts(): array
    {
        return [
            'tahun_terbit' => 'integer',
            'jumlah_halaman' => 'integer',
            'stok_total' => 'integer',
            'stok_tersedia' => 'integer',
        ];
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'id_penerbit', 'id_penerbit');
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class, 'id_rak', 'id_rak');
    }

    public function detailPeminjamans()
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_buku', 'id_buku');
    }

    public function reservasis()
    {
        return $this->hasMany(Reservasi::class, 'id_buku', 'id_buku');
    }

    public function scopeTersedia(Builder $query)
    {
        return $query->where('stok_tersedia', '>', 0);
    }
}
