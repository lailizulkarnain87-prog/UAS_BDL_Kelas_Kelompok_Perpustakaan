<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Reservasi extends Model
{
    protected $table = 'reservasis';
    protected $primaryKey = 'id_reservasi';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_anggota',
        'id_buku',
        'tanggal_reservasi',
        'tanggal_kedaluwarsa',
        'status_reservasi'
    ];

    protected function casts(): array
    {
        return [
            'tanggal_reservasi' => 'datetime',
            'tanggal_kedaluwarsa' => 'date',
        ];
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    public function scopeMenunggu(Builder $query)
    {
        return $query->where('status_reservasi', 'menunggu');
    }
}
