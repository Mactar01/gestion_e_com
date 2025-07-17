@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détail de la commande</h1>
    <div class="mb-3">
        <strong>Client :</strong> {{ $order->user->name ?? '-' }}<br>
        <strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}<br>
        <strong>Adresse de livraison :</strong> {{ $order->address }}<br>
        <strong>Statut :</strong> {{ ucfirst($order->status) }}<br>
        <strong>Paiement :</strong> {{ $order->paid ? 'Payé' : 'Non payé' }}<br>
        <strong>Mode de paiement :</strong> {{ $order->payment_method == 'en_ligne' ? 'En ligne' : 'À la livraison' }}<br>
    </div>
    <h4>Produits commandés</h4>
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
            @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name ?? '-' }}</td>
                    <td>{{ number_format($item->price, 2) }} €</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price * $item->quantity, 2) }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="text-end">
        <strong>Total : {{ number_format($order->total, 2) }} €</strong>
    </div>
    @if($order->invoice)
        <a href="{{ route('admin.orders.invoice', $order) }}" class="btn btn-primary mt-2">Télécharger la facture PDF</a>
    @endif
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
</div>
@endsection 