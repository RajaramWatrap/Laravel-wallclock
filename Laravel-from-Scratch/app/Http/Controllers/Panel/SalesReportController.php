<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'daily'); // Default to 'daily'
        $salesData = $this->getSalesData($filter);

        // Debugging: Check if data is retrieved
        // dd($salesData);

        return view('panel.reports.sales', compact('salesData', 'filter'));
    }

    private function getSalesData($type)
    {
        $query = DB::table('orders')
            ->join('order_product', 'orders.id', '=', 'order_product.order_id')
            ->join('products', 'order_product.product_id', '=', 'products.id')
            ->selectRaw('DATE(orders.created_at) as date, COUNT(DISTINCT orders.id) as orders, SUM(order_product.quantity * products.price) as sales')
            ->whereIn('orders.status', ['completed', 'paid']); // ✅ Fix: Include both 'completed' and 'paid'

        if ($type === 'daily') {
            // ✅ Fix: Use startOfDay() and endOfDay() for accurate filtering
            $query->whereBetween('orders.created_at', [
                Carbon::today()->startOfDay(),
                Carbon::today()->endOfDay(),
            ]);
        } elseif ($type === 'weekly') {
            // ✅ Fix: Use startOfWeek() and endOfWeek() to get full week range
            $query->whereBetween('orders.created_at', [
                Carbon::now()->startOfWeek()->startOfDay(),
                Carbon::now()->endOfWeek()->endOfDay(),
            ]);
        } elseif ($type === 'monthly') {
            // ✅ Fix: Use startOfMonth() and endOfMonth() to cover full month
            $query->whereBetween('orders.created_at', [
                Carbon::now()->startOfMonth()->startOfDay(),
                Carbon::now()->endOfMonth()->endOfDay(),
            ]);
        }

        return $query->groupBy('date')->orderBy('date', 'desc')->get();
    }
}
