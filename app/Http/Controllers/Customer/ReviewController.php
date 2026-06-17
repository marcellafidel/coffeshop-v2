<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'idProduk' => 'required|exists:menus,idProduk',
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        // Cek sudah pernah review belum
        $existing = Review::where('user_id', auth()->id())
            ->where('idProduk', $request->idProduk)
            ->first();

        if ($existing) {
            return back()->withErrors(['review' => 'Kamu sudah pernah memberikan review untuk produk ini.']);
        }

        Review::create([
            'user_id'  => auth()->id(),
            'idProduk' => $request->idProduk,
            'rating'   => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Review berhasil ditambahkan!');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }
        $review->delete();
        return back()->with('success', 'Review dihapus.');
    }
}