<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $primaryKey = 'id_kategori';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'kode_kategori',
        'nama_kategori',
        'deskripsi'
    ];

    public function bukus()
    {
        return $this->hasMany(Buku::class, 'id_kategori', 'id_kategori');
    }

    public function scopeUrutNama(Builder $query)
    {
        return $query->orderBy('nama_kategori');
    }
}
