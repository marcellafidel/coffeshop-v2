<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promo extends Model
{
    protected $fillable = [
        'kode', 'nama', 'deskripsi', 'tipe', 'nilai',
        'min_belanja', 'maks_diskon', 'kuota', 'terpakai',
        'tgl_mulai', 'tgl_selesai', 'is_active'
    ];

    protected $casts = [
        'tgl_mulai'   => 'date',
        'tgl_selesai' => 'date',
        'is_active'   => 'boolean',
    ];

    public function isValid(): bool
    {
        $now = Carbon::today();
        return $this->is_active
            && $now->between($this->tgl_mulai, $this->tgl_selesai)
            && ($this->kuota === null || $this->terpakai < $this->kuota);
    }

    public function hitungDiskon(float $total): float
    {
        if ($total < $this->min_belanja) return 0;

        $diskon = $this->tipe === 'persen'
            ? $total * ($this->nilai / 100)
            : $this->nilai;

        if ($this->maks_diskon) {
            $diskon = min($diskon, $this->maks_diskon);
        }

        return $diskon;
    }
}