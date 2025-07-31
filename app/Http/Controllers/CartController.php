<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Afficher le panier
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        return view('cart.index', compact('cart', 'total'));
    }

    // Ajouter un produit au panier
    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', 1);
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
        return redirect()->route('cart.index')->with('success', 'Produit ajouté au panier.');
    }

    // Mettre à jour la quantité d'un produit
    public function update(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $request->input('quantity', 1);
            session(['cart' => $cart]);
        }
        return redirect()->route('cart.index')->with('success', 'Quantité mise à jour.');
    }

    // Supprimer un produit du panier
    public function remove(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session(['cart' => $cart]);
        }
        return redirect()->route('cart.index')->with('success', 'Produit retiré du panier.');
    }
}
