<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture {{ $invoiceNumber }}</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .company-info {
            text-align: left;
            margin-bottom: 30px;
        }
        .invoice-info {
            text-align: right;
            margin-bottom: 30px;
        }
        .client-info {
            margin-bottom: 30px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background: #007bff;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .total {
            text-align: right;
            font-size: 1.2em;
            font-weight: bold;
            margin-top: 20px;
            padding: 15px;
            background-color: #e9ecef;
            border-radius: 5px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 0.9em;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .logo {
            font-size: 2em;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">AutoPremium</div>
        <h1>FACTURE</h1>
    </div>

    <div style="display: flex; justify-content: space-between; margin-bottom: 30px;">
        <div class="company-info">
            <h3>AutoPremium</h3>
            <p>123 Rue de l'Automobile<br>
            75001 Paris, France<br>
            Tél: +33 1 23 45 67 89<br>
            Email: contact@autopremium.fr</p>
        </div>

        <div class="invoice-info">
            <h3>Facture n° {{ $invoiceNumber }}</h3>
            <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y') }}</p>
            <p><strong>Statut :</strong> {{ ucfirst($order->status) }}</p>
        </div>
    </div>

    <div class="client-info">
        <h3>Informations client</h3>
        <p><strong>Nom :</strong> {{ $order->user->name ?? '-' }}</p>
        <p><strong>Email :</strong> {{ $order->user->email }}</p>
        <p><strong>Adresse de livraison :</strong> {{ $order->address }}</p>
        <p><strong>Mode de paiement :</strong> {{ $order->payment_method == 'en_ligne' ? 'En ligne' : 'À la livraison' }}</p>
    </div>

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
                    <td>{{ number_format($item->price, 2, ',', ' ') }} €</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price * $item->quantity, 2, ',', ' ') }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <strong>Total TTC : {{ number_format($order->total, 2, ',', ' ') }} €</strong>
    </div>

    <div class="footer">
        <p>Merci de votre confiance !</p>
        <p>AutoPremium - Votre spécialiste des véhicules premium</p>
        <p>Cette facture a été générée automatiquement le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>
</body>
</html>
