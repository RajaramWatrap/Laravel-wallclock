<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\PanelProduct; // ✅ Use PanelProduct instead of Product

class ProductController extends Controller
{
    public function index()
    {
        $products = PanelProduct::with('images')->get(); // ✅ Eager load images
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(ProductRequest $request)
    {
        $product = PanelProduct::create($request->validated());

        return redirect()
            ->route('panel.products.index')
            ->with('success', "New product with ID {$product->id} was created.");
    }

    public function show(PanelProduct $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(PanelProduct $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(ProductRequest $request, PanelProduct $product)
    {
        $product->update($request->validated());

        return redirect()
            ->route('panel.products.index')
            ->with('success', "The product with ID {$product->id} was updated.");
    }

    public function destroy(PanelProduct $product)
    {
        $product->delete();

        return redirect()
            ->route('panel.products.index')
            ->with('success', "The product with ID {$product->id} was removed.");
    }
}
