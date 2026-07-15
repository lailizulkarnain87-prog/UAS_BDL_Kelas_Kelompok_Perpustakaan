<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Penerbit extends Model
{
    protected $table = 'penerbits';
    protected $primaryKey = 'id_penerbit';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'nama_penerbit',
        'kota',
        'email',
        'no_telepon'
    ];

    public function bukus()
    {
        return $this->hasMany(Buku::class, 'id_penerbit', 'id_penerbit');
    }

    public function scopeBerdasarkanKota(Builder $query, $kota)
    {
        return $query->where('kota', $kota);
    }
}
