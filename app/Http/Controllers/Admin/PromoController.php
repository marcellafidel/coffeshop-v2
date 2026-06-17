<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->paginate(10);
        return view('admin.promos.index', compact('promos'));
    }

    public function create()
    {
        return view('admin.promos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'        => 'required|unique:promos,kode|max:20',
            'nama'        => 'required|string|max:100',
            'tipe'        => 'required|in:persen,nominal',
            'nilai'       => 'required|numeric|min:0',
            'min_belanja' => 'nullable|numeric|min:0',
            'maks_diskon' => 'nullable|numeric|min:0',
            'kuota'       => 'nullable|integer|min:1',
            'tgl_mulai'   => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        Promo::create($request->all());
        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil ditambahkan!');
    }

    public function edit(Promo $promo)
    {
        return view('admin.promos.edit', compact('promo'));
    }

    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'nama'        => 'required|string|max:100',
            'tipe'        => 'required|in:persen,nominal',
            'nilai'       => 'required|numeric|min:0',
            'tgl_mulai'   => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        $promo->update($request->all());
        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil diupdate!');
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();
        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil dihapus!');
    }

    public function show(Promo $promo) {}
}