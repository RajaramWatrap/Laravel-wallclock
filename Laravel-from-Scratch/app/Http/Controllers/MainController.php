<?php

namespace App\Http\Controllers;

use App\Models\Product; // ✅ Ensure correct namespace

class MainController extends Controller
{
    public function index()
    {
        $products = Product::available()->get(); // ✅ Fetch only available products

        return view('welcome', compact('products')); // ✅ Corrected return statement
    }
}
