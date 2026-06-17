<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Kategori;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $menus = Menu::withCount('reviews')->withAvg('reviews', 'rating')->latest()->take(6)->get();
        return view('customer.home', compact('menus'));
    }

    public function menu(Request $request)
    {
        $query = Menu::withCount('reviews')->withAvg('reviews', 'rating')->with('kategori');

        // Filter pencarian
        if ($request->search) {
            $query->where('namaProduk', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter harga
        if ($request->harga_min) {
            $query->where('harga', '>=', $request->harga_min);
        }
        if ($request->harga_max) {
            $query->where('harga', '<=', $request->harga_max);
        }

        // Sort
        match($request->sort) {
            'harga_asc'  => $query->orderBy('harga', 'asc'),
            'harga_desc' => $query->orderBy('harga', 'desc'),
            'rating'     => $query->orderByDesc('reviews_avg_rating'),
            default      => $query->latest(),
        };

        $menus     = $query->paginate(9)->withQueryString();
        $kategoris = Kategori::all();

        return view('customer.menu', compact('menus', 'kategoris'));
    }
}