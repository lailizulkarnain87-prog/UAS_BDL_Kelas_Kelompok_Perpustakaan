<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Denda extends Model
{
    protected $table = 'dendas';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'id_pengembalian',
        'id_anggota',
        'total_denda',
        'sisa_denda',
        'status_denda',
        'tanggal_dikenakan',
        'tanggal_jatuh_tempo',
        'alasan_denda',
        'created_by'
    ];

    protected function casts(): array
    {
        return [
            'total_denda' => 'decimal:2',
            'sisa_denda' => 'decimal:2',
            'tanggal_dikenakan' => 'date',
            'tanggal_jatuh_tempo' => 'date',
        ];
    }

    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class, 'id_pengembalian', 'id_pengembalian');
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'created_by', 'id_petugas');
    }

    public function pembayaranDendas()
    {
        return $this->hasMany(PembayaranDenda::class, 'id_denda', 'id');
    }

    public function riwayatStatusDendas()
    {
        return $this->hasMany(RiwayatStatusDenda::class, 'id_denda', 'id');
    }

    public function scopeDendaPending(Builder $query)
    {
        return $query->where('status_denda', 'pending');
    }
}
