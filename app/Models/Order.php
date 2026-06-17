<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'idOrder';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idOrder', 'idCustomer', 'tanggal_order', 'total_harga',
        'alamat_pengiriman', 'status', 'bukti_pembayaran',
        'status_pembayaran', 'payment_method', 'confirmed_by', 'confirmed_at'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'idCustomer', 'idCust');
    }
}