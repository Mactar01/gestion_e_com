@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Éditer la commande</h1>
    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="status" class="form-label">Statut</label>
            <select name="status" class="form-control" required>
                <option value="en attente" @if($order->status == 'en attente') selected @endif>En attente</option>
                <option value="expédiée" @if($order->status == 'expédiée') selected @endif>Expédiée</option>
                <option value="livrée" @if($order->status == 'livrée') selected @endif>Livrée</option>
                <option value="annulée" @if($order->status == 'annulée') selected @endif>Annulée</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="paid" class="form-label">Paiement</label>
            <select name="paid" class="form-control" required>
                <option value="1" @if($order->paid) selected @endif>Payé</option>
                <option value="0" @if(!$order->paid) selected @endif>Non payé</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection 