<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Statistiques pour la page d'accueil
        $stats = [
            'total_vehicles' => Product::count(),
            'happy_clients' => User::where('is_admin', false)->count(),
            'years_experience' => 15,
        ];

        // Véhicules en vedette (les plus récents ou les plus populaires)
        $featured_products = Product::with('category')
            ->where('stock', '>', 0)
            ->latest()
            ->limit(6)
            ->get();

        // Si pas assez de produits récents, prendre les produits avec le plus de stock
        if ($featured_products->count() < 6) {
            $featured_products = Product::with('category')
                ->where('stock', '>', 0)
                ->orderBy('stock', 'desc')
                ->limit(6)
                ->get();
        }

        return view('home', compact('stats', 'featured_products'));
    }
}
