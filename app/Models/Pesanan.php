<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $primaryKey = 'idPesanan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idPesanan', 'idCust', 'idProduk', 'idBayar',
        'tglPesanan', 'jumPesanan', 'metodePembayaran', 'catatan'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'idCust', 'idCust');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'idProduk', 'idProduk');
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'idPesanan', 'idPesanan');
    }
}