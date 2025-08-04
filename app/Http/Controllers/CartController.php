<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    // Afficher le panier
    public function index()
    {
        // Vérifier que l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder au panier.');
        }

        $cart = session()->get('cart', []);
        Log::info('Cart contents for user ' . auth()->id() . ': ' . json_encode($cart));

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('cart.index', compact('cart', 'total'));
    }

    // Ajouter un produit au panier
    public function add(Request $request, Product $product)
    {
        // Vérifier que l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour ajouter des produits au panier.');
        }

        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', 1);

        // Vérifier que la quantité ne dépasse pas le stock disponible
        if ($quantity > $product->stock) {
            return back()->with('error', 'La quantité demandée dépasse le stock disponible.');
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => $quantity,
            ];
        }

        session(['cart' => $cart]);
        Log::info('Product added to cart: ' . $product->name . ' by user ' . auth()->id());

        return redirect()->route('cart.index')->with('success', 'Produit ajouté au panier.');
    }

    // Mettre à jour la quantité d'un produit
    public function update(Request $request, Product $product)
    {
        // Vérifier que l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour modifier le panier.');
        }

        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', 1);

        // Vérifier que la quantité ne dépasse pas le stock disponible
        if ($quantity > $product->stock) {
            return back()->with('error', 'La quantité demandée dépasse le stock disponible.');
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $quantity;
            session(['cart' => $cart]);
            Log::info('Cart updated for user ' . auth()->id() . ': ' . $product->name . ' quantity = ' . $quantity);
        }

        return redirect()->route('cart.index')->with('success', 'Quantité mise à jour.');
    }

    // Supprimer un produit du panier
    public function remove(Request $request, Product $product)
    {
        // Vérifier que l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour modifier le panier.');
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session(['cart' => $cart]);
            Log::info('Product removed from cart: ' . $product->name . ' by user ' . auth()->id());
        }

        return redirect()->route('cart.index')->with('success', 'Produit retiré du panier.');
    }
}
