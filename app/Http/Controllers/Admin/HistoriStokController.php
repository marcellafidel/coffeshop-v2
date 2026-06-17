<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HistoriStok;

class HistoriStokController extends Controller
{
    public function index()
    {
        $histori = HistoriStok::with('menu')
            ->latest('created_at')
            ->paginate(20);

        return view('admin.histori-stok.index', compact('histori'));
    }
}