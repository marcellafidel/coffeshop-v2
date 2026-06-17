<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Menu::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaProduk' => 'required|string|max:255',
            'harga'      => 'required|numeric',
            'stok'       => 'required|integer',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();
        $data['idProduk'] = 'PRD' . strtoupper(Str::random(3));

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Menu::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Menu $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Menu $product)
    {
        $request->validate([
            'namaProduk' => 'required|string|max:255',
            'harga'      => 'required|numeric',
            'stok'       => 'required|integer',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Menu $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function show(Menu $product)
    {
        return view('admin.products.show', compact('product'));
    }
}