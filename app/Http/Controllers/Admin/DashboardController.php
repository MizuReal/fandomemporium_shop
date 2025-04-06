<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $yearlySales = $this->getYearlySales();
        $monthlySales = $this->getMonthlySales();
        $productSalesPercentage = $this->getProductSalesPercentage();
        
        return view('admin.dashboard', compact('yearlySales', 'monthlySales', 'productSalesPercentage'));
    }
    
    /**
     * Get yearly sales data for the past 2 years
     */
    private function getYearlySales()
    {
        $currentYear = Carbon::now()->year;
        $previousYear = $currentYear - 1;
        
        $yearlySales = Order::selectRaw('YEAR(created_at) as year, SUM(total_amount) as total')
            ->whereIn('status', ['shipped', 'delivered'])
            ->whereYear('created_at', '>=', $previousYear)
            ->groupBy('year')
            ->orderBy('year')
            ->get()
            ->keyBy('year')
            ->map(function ($item) {
                return round($item->total, 2);
            })
            ->toArray();
            
        // Ensure we have data for both years
        if (!isset($yearlySales[$currentYear])) {
            $yearlySales[$currentYear] = 0;
        }
        if (!isset($yearlySales[$previousYear])) {
            $yearlySales[$previousYear] = 0;
        }
        
        return [
            'years' => [$previousYear, $currentYear],
            'data' => [$yearlySales[$previousYear], $yearlySales[$currentYear]],
        ];
    }
    
    /**
     * Get monthly sales data for the current year
     */
    private function getMonthlySales()
    {
        $currentYear = Carbon::now()->year;
        
        $months = [];
        $monthlySalesData = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('M', mktime(0, 0, 0, $i, 1));
            $monthlySalesData[$i] = 0;
        }
        
        $monthlySales = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->whereIn('status', ['shipped', 'delivered'])
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        foreach ($monthlySales as $sale) {
            $monthlySalesData[$sale->month] = round($sale->total, 2);
        }
        
        return [
            'months' => $months,
            'data' => array_values($monthlySalesData),
        ];
    }
    
    /**
     * Get sales data with date range filter
     */
    public function getSalesWithDateRange(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());
        
        $salesData = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->whereIn('status', ['shipped', 'delivered'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        return response()->json([
            'dates' => $salesData->pluck('date')->toArray(),
            'data' => $salesData->pluck('total')->toArray(),
        ]);
    }
    
    /**
     * Get product sales percentage data
     */
    private function getProductSalesPercentage()
    {
        $productSales = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereIn('orders.status', ['shipped', 'delivered'])
            ->select(
                'products.name',
                DB::raw('SUM(order_items.quantity * order_items.price) as total_sales')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sales', 'desc')
            ->limit(5)
            ->get();
            
        $totalSales = $productSales->sum('total_sales');
        if ($totalSales == 0) {
            $totalSales = 1; // Prevent division by zero
        }
        
        $data = [];
        foreach ($productSales as $product) {
            $percentage = round(($product->total_sales / $totalSales) * 100, 2);
            $data[] = [
                'name' => $product->name,
                'value' => $percentage,
                'sales' => round($product->total_sales, 2)
            ];
        }
        
        return $data;
    }
}
