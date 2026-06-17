<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $primaryKey = 'idCust';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idCust', 'nama', 'email', 'password', 'telp', 'alamat', 'tglDaftar'
    ];

    protected $hidden = ['password'];

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'idCust', 'idCust');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'idCustomer', 'idCust');
    }
}