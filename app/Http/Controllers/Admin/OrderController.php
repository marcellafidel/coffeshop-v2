<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Pesanan::with('customer')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Pesanan::with(['customer', 'detailPesanans'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function update($id)
    {
        $order = Pesanan::findOrFail($id);
        $order->update(['status' => request('status')]);
        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan diupdate!');
    }
}