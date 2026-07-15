<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class DetailPeminjaman extends Model
{
    protected $table = 'detail_peminjamans';
    protected $primaryKey = 'id_detail';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_peminjaman',
        'id_buku',
        'status_buku'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'id_detail', 'id_detail');
    }

    public function scopeDipinjam(Builder $query)
    {
        return $query->where('status_buku', 'dipinjam');
    }
}
