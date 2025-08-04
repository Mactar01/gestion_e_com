<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture {{ $invoiceNumber }}</title>
    <style>
<<<<<<< HEAD
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
=======
        @page {
            margin: 2cm;
            size: A4;
        }
        
        body { 
            font-family: DejaVu Sans, Arial, sans-serif; 
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 20px;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }
        
        .company-info {
            font-size: 10px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .invoice-title {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            margin: 20px 0;
        }
        
        .invoice-details {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        
        .invoice-details-row {
            display: table-row;
        }
        
        .invoice-details-cell {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 5px 0;
        }
        
        .customer-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #667eea;
        }
        
        .customer-info h3 {
            margin: 0 0 10px 0;
            color: #667eea;
            font-size: 14px;
        }
        
        .invoice-meta {
            text-align: right;
        }
        
        .invoice-number {
            font-size: 16px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .invoice-date {
            color: #666;
            margin-bottom: 5px;
        }
        
        .payment-info {
            background-color: #e8f5e8;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 20px 0;
            font-size: 11px;
        }
        
        th { 
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        
        td { 
            padding: 10px 8px;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .product-name {
            font-weight: bold;
            color: #2c3e50;
        }
        
        .product-description {
            font-size: 10px;
            color: #666;
            margin-top: 3px;
        }
        
        .quantity {
            text-align: center;
        }
        
        .price {
            text-align: right;
            font-weight: bold;
        }
        
        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        .total-row td {
            border-top: 2px solid #667eea;
            border-bottom: none;
        }
        
        .total-amount {
            font-size: 16px;
            color: #28a745;
            text-align: right;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #666;
            text-align: center;
        }
        
        .terms {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        
        .terms h4 {
            margin: 0 0 10px 0;
            color: #856404;
            font-size: 12px;
        }
        
        .terms p {
            margin: 5px 0;
            font-size: 10px;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: inline-block;
            margin-bottom: 10px;
            position: relative;
        }
        
        .logo::after {
            content: "EC";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: bold;
            font-size: 20px;
>>>>>>> 67797e28225dc09dffa7355be39ecd45881ad812
        }
    </style>
</head>
<body>
    <div class="header">
<<<<<<< HEAD
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

=======
        <div class="logo"></div>
        <div class="company-name">E-Commerce Premium</div>
        <div class="company-info">
            123 Rue du Commerce<br>
            75001 Paris, France<br>
            Tél: +33 1 23 45 67 89<br>
            Email: contact@ecommerce-premium.com<br>
            SIRET: 123 456 789 00012
        </div>
    </div>
    
    <div class="invoice-title">FACTURE</div>
    
    <div class="invoice-details">
        <div class="invoice-details-row">
            <div class="invoice-details-cell">
                <div class="customer-info">
                    <h3>INFORMATIONS CLIENT</h3>
                    <strong>{{ $order->user->name ?? 'Client' }}</strong><br>
                    Email: {{ $order->user->email }}<br>
                    <br>
                    <strong>Adresse de livraison :</strong><br>
                    {{ $order->address }}
                </div>
            </div>
            <div class="invoice-details-cell">
                <div class="invoice-meta">
                    <div class="invoice-number">{{ $invoiceNumber }}</div>
                    <div class="invoice-date">
                        <strong>Date de facture :</strong><br>
                        {{ $order->created_at->format('d/m/Y') }}
                    </div>
                    <div class="invoice-date">
                        <strong>Date de commande :</strong><br>
                        {{ $order->created_at->format('d/m/Y à H:i') }}
                    </div>
                    <div class="payment-info">
                        <strong>Mode de paiement :</strong><br>
                        @if($order->payment_method == 'en_ligne')
                            💳 Paiement en ligne
                        @else
                            💰 Paiement à la livraison
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
>>>>>>> 67797e28225dc09dffa7355be39ecd45881ad812
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 45%;">Produit</th>
                <th style="width: 15%;">Prix unitaire</th>
                <th style="width: 10%;">Qté</th>
                <th style="width: 15%;">Total HT</th>
                <th style="width: 10%;">TVA</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $index => $item)
                <tr>
<<<<<<< HEAD
                    <td>{{ $item->product->name ?? '-' }}</td>
                    <td>{{ number_format($item->price, 2, ',', ' ') }} €</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price * $item->quantity, 2, ',', ' ') }} €</td>
=======
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>
                        <div class="product-name">{{ $item->product->name ?? 'Produit' }}</div>
                        @if($item->product && $item->product->description)
                            <div class="product-description">{{ Str::limit($item->product->description, 50) }}</div>
                        @endif
                    </td>
                    <td class="price">{{ number_format($item->price / 1.2, 2, ',', ' ') }} €</td>
                    <td class="quantity">{{ $item->quantity }}</td>
                    <td class="price">{{ number_format(($item->price / 1.2) * $item->quantity, 2, ',', ' ') }} €</td>
                    <td class="price">{{ number_format((($item->price / 1.2) * $item->quantity) * 0.2, 2, ',', ' ') }} €</td>
>>>>>>> 67797e28225dc09dffa7355be39ecd45881ad812
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" style="text-align: right;"><strong>Total HT :</strong></td>
                <td class="price">{{ number_format($order->total / 1.2, 2, ',', ' ') }} €</td>
                <td></td>
            </tr>
            <tr class="total-row">
                <td colspan="4" style="text-align: right;"><strong>TVA (20%) :</strong></td>
                <td class="price">{{ number_format(($order->total / 1.2) * 0.2, 2, ',', ' ') }} €</td>
                <td></td>
            </tr>
            <tr class="total-row">
                <td colspan="4" style="text-align: right;"><strong>Total TTC :</strong></td>
                <td class="total-amount">{{ number_format($order->total, 2, ',', ' ') }} €</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
<<<<<<< HEAD

    <div class="total">
        <strong>Total TTC : {{ number_format($order->total, 2, ',', ' ') }} €</strong>
    </div>

    <div class="footer">
        <p>Merci de votre confiance !</p>
        <p>AutoPremium - Votre spécialiste des véhicules premium</p>
        <p>Cette facture a été générée automatiquement le {{ now()->format('d/m/Y à H:i') }}</p>
=======
    
    <div class="terms">
        <h4>Conditions de vente :</h4>
        <p>• Paiement à 30 jours</p>
        <p>• Livraison sous 3-5 jours ouvrés</p>
        <p>• Garantie 2 ans sur tous nos produits</p>
        <p>• Retours acceptés sous 14 jours</p>
    </div>
    
    <div class="footer">
        <p><strong>E-Commerce Premium</strong> - Votre partenaire de confiance</p>
        <p>Merci de votre confiance ! 🙏</p>
        <p>Pour toute question, contactez-nous : support@ecommerce-premium.com</p>
>>>>>>> 67797e28225dc09dffa7355be39ecd45881ad812
    </div>
</body>
</html>
