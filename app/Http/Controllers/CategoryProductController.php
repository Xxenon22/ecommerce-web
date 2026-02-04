<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;

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
    public function index_user()
    {
        $categories = CategoryProduct::all();
        $products = collect(); // kosong tapi aman
        return view('category', compact('categories', 'products'));
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
    public function show_user(CategoryProduct $category)
    {
        $products = $category->products;
        return view('category', compact('category', 'products'));
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
