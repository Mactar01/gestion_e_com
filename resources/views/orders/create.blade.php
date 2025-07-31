@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Passer la commande</h1>
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="address" class="form-label">Adresse de livraison</label>
            <input type="text" name="address" class="form-control" value="{{ old('address') }}" required>
        </div>
        <div class="mb-3">
            <label for="payment_method" class="form-label">Mode de paiement</label>
            <select name="payment_method" class="form-control" required>
                <option value="en_ligne">Paiement en ligne (simulé)</option>
                <option value="a_la_livraison">Paiement à la livraison</option>
            </select>
        </div>
        <h4>Récapitulatif du panier</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ number_format($item['price'], 2) }} €</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ number_format($item['price'] * $item['quantity'], 2) }} €</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-end mb-3">
            <strong>Total : {{ number_format($total, 2) }} €</strong>
        </div>
        <button type="submit" class="btn btn-success">Valider la commande</button>
        <a href="{{ route('cart.index') }}" class="btn btn-secondary">Retour au panier</a>
    </form>
</div>
@endsection 