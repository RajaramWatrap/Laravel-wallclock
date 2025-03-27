<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index()
    {
        DB::connection()->enableQueryLog(); // ✅ Enable query logging
        $products = Product::all();

        return view('welcome')->with([
            'products' => $products,
        ]);
    }
}
