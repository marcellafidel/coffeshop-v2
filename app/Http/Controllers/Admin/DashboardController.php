<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Menu;
use App\Models\Customer;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPesanan  = Pesanan::count();
        $totalMenu     = Menu::count();
        $totalCustomer = Customer::count();
        $pesananTerbaru = Pesanan::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPesanan', 'totalMenu', 'totalCustomer', 'pesananTerbaru'
        ));
    }
}