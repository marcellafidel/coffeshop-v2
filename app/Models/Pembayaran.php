<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $primaryKey = 'idBayar';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idBayar', 'metodePembayaran', 'buktiBayar',
        'catatan_admin', 'total', 'tglBayar', 'statusBayar'
    ];
}