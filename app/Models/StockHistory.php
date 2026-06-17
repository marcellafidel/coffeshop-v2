<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    protected $fillable = [
        'idProduk', 'admin_id', 'action_type',
        'old_stock', 'new_stock', 'quantity_changed', 'reason'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'idProduk', 'idProduk');
    }
}