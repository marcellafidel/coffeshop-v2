<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;

class HomeController extends Controller
{
    public function index()
    {
        $menus = Menu::latest()->take(6)->get();
        return view('customer.home', compact('menus'));
    }

    public function menu()
    {
        $menus = Menu::all();
        return view('customer.menu', compact('menus'));
    }

    public function menu()
    {
        $menus = Menu::withCount('reviews')->withAvg('reviews', 'rating')->get();
        return view('customer.menu', compact('menus'));
    }
}