<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(5);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'details' => 'required',
        ]);

        Product::create($request->only('name','details'));

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'details' => 'required',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->only('name','details'));

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(string $id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }

    // 🔥 New method: View All Products (tanpa edit/delete)
    public function viewAll()
    {
        $products = Product::all();
        return view('products.viewall', compact('products'));
    }
}
