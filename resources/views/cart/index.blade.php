@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mon Panier</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(count($cart) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $id => $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ number_format($item['price'], 2) }} €</td>
                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" style="width:60px;">
                                <button type="submit" class="btn btn-sm btn-primary">Mettre à jour</button>
                            </form>
                        </td>
                        <td>{{ number_format($item['price'] * $item['quantity'], 2) }} €</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-end">
            <h4>Total : {{ number_format($total, 2) }} €</h4>
            <a href="{{ route('orders.create') }}" class="btn btn-success">Passer la commande</a>
        </div>
    @else
        <p>Votre panier est vide.</p>
    @endif
</div>
@endsection 