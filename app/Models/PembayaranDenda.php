<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PembayaranDenda extends Model
{
    protected $table = 'pembayaran_dendas';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'id_denda',
        'id_petugas',
        'jumlah_bayar',
        'tanggal_bayar',
        'metode_bayar',
        'bukti_bayar',
        'keterangan'
    ];

    protected function casts(): array
    {
        return [
            'jumlah_bayar' => 'decimal:2',
            'tanggal_bayar' => 'datetime',
        ];
    }

    public function denda()
    {
        return $this->belongsTo(Denda::class, 'id_denda', 'id');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    public function scopeTunai(Builder $query)
    {
        return $query->where('metode_bayar', 'tunai');
    }
}
