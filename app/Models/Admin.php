<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $primaryKey = 'idAdmin';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idAdmin', 'email', 'password', 'telp', 'role', 'tglBergabung', 'nama'
    ];

    protected $hidden = ['password'];
}