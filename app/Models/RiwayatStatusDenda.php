<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class RiwayatStatusDenda extends Model
{
    protected $table = 'riwayat_status_dendas';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'id_denda',
        'status_sebelum',
        'status_sesudah',
        'diubah_oleh',
        'alasan'
    ];

    public function denda()
    {
        return $this->belongsTo(Denda::class, 'id_denda', 'id');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'diubah_oleh', 'id_petugas');
    }

    public function scopeTerbaru(Builder $query)
    {
        return $query->latest();
    }
}
