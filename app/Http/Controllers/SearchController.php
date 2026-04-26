<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Edukasi;
use App\Models\Restaurant;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->q;

        $products = Product::where('name', 'like', "%$query%")->get();
        $edukasis = Edukasi::where('judul', 'like', "%$query%")->get();
        $restaurants = Restaurant::where('name', 'like', "%$query%")->get();

        return view('components.search', compact('query', 'products', 'edukasis', 'restaurants'));
    }

    public function searchPage(Request $request)
    {
        $q = strtolower($request->q);

        if (str_contains($q, 'dashboard') || str_contains($q, 'home')) {
            return redirect()->route('admin.dashboard');
        }

        if (str_contains($q, 'user')) {
            return redirect('/admin/user');
        }

        if (str_contains($q, 'education') || str_contains($q, 'edukasi')) {
            return redirect('/admin/education');
        }

        if (str_contains($q, 'history') || str_contains($q, 'riwayat') || str_contains($q, 'histori')) {
            return redirect('/admin/history');
        }

        // kalau tidak ketemu
        return back()->with('error', 'Halaman tidak ditemukan 😢');
    }

}