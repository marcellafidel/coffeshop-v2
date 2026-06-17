<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $primaryKey = 'idDetail';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idDetail', 'idPesanan', 'idMenu', 'namaMenu',
        'jumlah', 'harga', 'subtotal', 'catatan'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'idPesanan', 'idPesanan');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'idMenu', 'idProduk');
    }
}