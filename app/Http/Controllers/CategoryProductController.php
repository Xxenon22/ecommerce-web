<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // Halaman Admin Category
    public function index()
    {
        $categories = CategoryProduct::all();
        return view('admin.category.index', compact('categories'));
    }
    // Halaman User Category
    public function index_user(Request $request)
    {
        $categories = CategoryProduct::all();
        $cartCount = Auth::check() ? Cart::where('user_id', Auth::user()->id)->count() : 0;

        $query = $request->q;

        $products = Product::query();

        // 🔍 SEARCH
        if ($query) {
            $products->where(function ($q) use ($query) {
                $q->where('name', 'like', "%$query%")
                    ->orWhere('description', 'like', "%$query%");
            });
        }

        $products = $products->get();

        return view('category', compact('categories', 'products', 'cartCount', 'query'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
        ]);

        CategoryProduct::create($request->all());

        return redirect('/admin/category')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */

    // Halaman User Category
    public function show_user(CategoryProduct $category, Request $request)
    {
        $categories = CategoryProduct::all();
        $cartCount = Auth::check() ? Cart::where('user_id', Auth::user()->id)->count() : 0;

        $query = $request->q;

        $products = $category->products(); // penting: pakai query, bukan ->products langsung

        // 🔍 SEARCH DALAM KATEGORI
        if ($query) {
            $products->where(function ($q) use ($query) {
                $q->where('name', 'like', "%$query%")
                    ->orWhere('description', 'like', "%$query%");
            });
        }

        $products = $products->get();

        return view('category', compact('categories', 'category', 'products', 'cartCount', 'query'));
    }

    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = CategoryProduct::findOrFail($id);
        $category->delete();

        return redirect('/admin/category')->with('success', 'Category deleted successfully.');
    }

    public function inlineUpdate(Request $request, $id)
    {
        $category = CategoryProduct::findOrFail($id);
        $category->{$request->field} = $request->value;
        $category->save();

        return response()->json(['success' => true]);
    }
}
