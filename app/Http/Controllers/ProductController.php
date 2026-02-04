<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('restaurant_id', auth()->user()->restaurant->id)
            ->with('category')
            ->get();

        return view('HomeResto', compact('products'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\CategoryProduct::all();
        return view('tambahMenu', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_product_id' => 'required|exists:category_products,id',
            'price' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'photo' => 'nullable|image|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('products', 'public');
        }

        Product::create([
            'restaurant_id' => auth()->user()->restaurant->id,
            'category_product_id' => $request->category_product_id,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'stock' => $request->stock,
            'photo' => $photoPath,
            'status' => true,
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        abort_if($product->restaurant_id !== auth()->user()->restaurant->id, 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_product_id' => 'required|exists:category_products,id',
            'price' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($product->photo) {
                \Storage::disk('public')->delete($product->photo);
            }
            $data['photo'] = $request->file('photo')->store('products', 'public');
        }

        $product->update($data);

        return back()->with('success', 'Product berhasil diupdate');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        abort_if($product->restaurant_id !== auth()->user()->restaurant->id, 403);

        if ($product->photo) {
            \Storage::disk('public')->delete($product->photo);
        }

        $product->delete();

        return back()->with('success', 'Product berhasil dihapus');
    }

}
