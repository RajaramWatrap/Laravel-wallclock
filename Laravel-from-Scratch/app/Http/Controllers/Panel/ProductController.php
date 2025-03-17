<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product; // ✅ Correct namespace

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create'); // ✅ Ensure you have this Blade file
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());

        return redirect()
            ->route('panel.products.index') // ✅ Fixed route name
            ->with('success', "New product with ID {$product->id} was created.");
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()
            ->route('panel.products.index') // ✅ Fixed route name
            ->with('success', "The product with ID {$product->id} was updated.");
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('panel.products.index') // ✅ Fixed route name
            ->with('success', "The product with ID {$product->id} was removed.");
    }
}
