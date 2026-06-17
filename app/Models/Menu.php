<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $primaryKey = 'idProduk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
    'idProduk', 'namaProduk', 'harga', 'deskripsi', 
    'stok', 'ukuran', 'tglDitambahkan', 'kategori_id'
];

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'idMenu', 'idProduk');
    }

    public function historiStoks()
    {
        return $this->hasMany(HistoriStok::class, 'idProduk', 'idProduk');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'idProduk', 'idProduk');
    }

    public function rataRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}