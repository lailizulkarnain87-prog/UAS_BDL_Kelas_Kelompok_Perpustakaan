<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Rak extends Model
{
    protected $table = 'raks';
    protected $primaryKey = 'id_rak';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'kode_rak',
        'nama_rak',
        'lantai',
        'kapasitas'
    ];

    protected function casts(): array
    {
        return [
            'lantai' => 'integer',
            'kapasitas' => 'integer',
        ];
    }

    public function bukus()
    {
        return $this->hasMany(Buku::class, 'id_rak', 'id_rak');
    }

    public function scopeLantai(Builder $query, $lantai)
    {
        return $query->where('lantai', $lantai);
    }
}
