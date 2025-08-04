<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annulation de commande</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .order-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #dc3545;
        }
        .product-item {
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #e9ecef;
        }
        .total {
            background: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            text-align: right;
            font-weight: bold;
            font-size: 1.1em;
        }
        .btn {
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
        }
        .info-box {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>❌ Commande annulée</h1>
        <p>Votre commande a été annulée avec succès</p>
    </div>

    <div class="content">
        <h2>Bonjour {{ $order->user->name }},</h2>

        <p>Nous confirmons l'annulation de votre commande. Les produits ont été remis en stock et sont à nouveau disponibles.</p>

        <div class="info-box">
            <h4>ℹ️ Informations importantes</h4>
            <p>• Les produits de votre commande ont été remis en stock<br>
            • Aucun montant ne vous sera débité<br>
            • Vous pouvez passer une nouvelle commande à tout moment</p>
        </div>

        <div class="order-details">
            <h3>📋 Détails de la commande annulée</h3>
            <p><strong>Numéro de commande :</strong> #{{ $orderNumber }}</p>
            <p><strong>Date de création :</strong> {{ $order->created_at->format('d/m/Y à H:i') }}</p>
            <p><strong>Date d'annulation :</strong> {{ now()->format('d/m/Y à H:i') }}</p>
            <p><strong>Statut :</strong> Annulée</p>
        </div>

        <h3>🚗 Produits de la commande annulée</h3>
        @foreach($order->orderItems as $item)
            <div class="product-item">
                <h4>{{ $item->product->name ?? 'Produit' }}</h4>
                <p><strong>Prix unitaire :</strong> {{ number_format($item->price, 2, ',', ' ') }} €</p>
                <p><strong>Quantité :</strong> {{ $item->quantity }}</p>
                <p><strong>Total :</strong> {{ number_format($item->price * $item->quantity, 2, ',', ' ') }} €</p>
            </div>
        @endforeach

        <div class="total">
            <strong>Total de la commande annulée : {{ number_format($order->total, 2, ',', ' ') }} €</strong>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('products.index') }}" class="btn">Voir nos véhicules</a>
            <a href="{{ route('orders.index') }}" class="btn">Mes commandes</a>
        </div>

        <div style="background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h4>📞 Besoin d'aide ?</h4>
            <p>Si vous avez des questions ou souhaitez passer une nouvelle commande, n'hésitez pas à nous contacter :</p>
            <p>📧 Email : contact@autopremium.fr<br>
            📞 Téléphone : +33 1 23 45 67 89</p>
        </div>
    </div>

    <div class="footer">
        <p><strong>AutoPremium</strong> - Votre spécialiste des véhicules premium</p>
        <p>123 Rue de l'Automobile, 75001 Paris, France</p>
        <p>Cet email a été envoyé automatiquement. Merci de ne pas y répondre.</p>
    </div>
</body>
</html>
