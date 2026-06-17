<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriStok extends Model
{
    protected $primaryKey = 'id_histori';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_histori', 'idProduk', 'namaProduk', 'stok_sebelum',
        'stok_sesudah', 'perubahan', 'jenis_perubahan',
        'keterangan', 'idAdmin', 'nama'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'idProduk', 'idProduk');
    }
}