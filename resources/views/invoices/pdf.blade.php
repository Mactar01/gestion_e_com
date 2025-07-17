<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture {{ $invoiceNumber }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background: #eee; }
        .total { text-align: right; font-size: 1.2em; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Facture n° {{ $invoiceNumber }}</h2>
    <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y') }}</p>
    <p><strong>Client :</strong> {{ $order->user->name ?? '-' }}<br>
    <strong>Email :</strong> {{ $order->user->email }}</p>
    <p><strong>Adresse de livraison :</strong> {{ $order->address }}</p>
    <p><strong>Mode de paiement :</strong> {{ $order->payment_method == 'en_ligne' ? 'En ligne' : 'À la livraison' }}</p>
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Prix unitaire</th>
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
    <p class="total">Total TTC : {{ number_format($order->total, 2) }} €</p>
</body>
</html> 