<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques générales
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_users' => User::where('role', '!=', 'admin')->count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total'),
        ];

        // Commandes récentes
        $recent_orders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Produits avec stock faible
        $low_stock_products = Product::where('stock', '<=', 5)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();

        // Données pour les graphiques
        $chart_data = $this->getChartData();

        return view('admin.dashboard', compact(
            'stats',
            'recent_orders',
            'low_stock_products',
            'chart_data'
        ));
    }

    private function getChartData()
    {
        // Données des ventes des 6 derniers mois
        $sales_data = [];
        $sales_labels = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $sales_labels[] = $date->format('M Y');
            
            $monthly_sales = Order::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', '!=', 'cancelled')
                ->sum('total');
                
            $sales_data[] = (float) $monthly_sales;
        }

        // Répartition par catégories
        $categories = Category::withCount('products')->get();
        $category_labels = $categories->pluck('name')->toArray();
        $category_data = $categories->pluck('products_count')->toArray();

        return [
            'sales_labels' => $sales_labels,
            'sales_data' => $sales_data,
            'category_labels' => $category_labels,
            'category_data' => $category_data,
        ];
    }
}
