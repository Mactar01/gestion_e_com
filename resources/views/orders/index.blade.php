@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mes Commandes</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Paiement</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ number_format($order->total, 2) }} €</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>{{ $order->paid ? 'Payé' : 'Non payé' }}</td>
                    <td><a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info">Détail</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $orders->links() }}
</div>
@endsection 