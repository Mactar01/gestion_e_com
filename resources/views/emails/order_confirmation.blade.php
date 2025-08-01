<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de commande</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        .order-details {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }
        .order-number {
            font-size: 20px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding: 5px 0;
        }
        .detail-label {
            font-weight: 600;
            color: #6c757d;
        }
        .detail-value {
            color: #2c3e50;
        }
        .total-section {
            background-color: #e8f5e8;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        .total-amount {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
        }
        .invoice-section {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        .invoice-link {
            display: inline-block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin-top: 10px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        .contact-info {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #dee2e6;
        }
        .thank-you {
            text-align: center;
            margin: 30px 0;
            font-size: 18px;
            color: #28a745;
            font-weight: 600;
        }
        @media only screen and (max-width: 600px) {
            .container {
                margin: 0;
                box-shadow: none;
            }
            .content {
                padding: 20px;
            }
            .header {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Confirmation de commande</h1>
            <p>Merci pour votre achat !</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                Bonjour <strong>{{ $order->user->name }}</strong>,
            </div>
            
            <p>Nous avons bien reçu votre commande et nous vous remercions pour votre confiance. Votre commande est maintenant en cours de traitement.</p>
            
            <div class="order-details">
                <div class="order-number">
                    Commande #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Date de commande :</span>
                    <span class="detail-value">{{ $order->created_at->format('d/m/Y à H:i') }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Statut :</span>
                    <span class="detail-value">
                        @if($order->status === 'en attente')
                            <span style="color: #ffc107;">⏳ En attente</span>
                        @elseif($order->status === 'en cours')
                            <span style="color: #17a2b8;">🔄 En cours</span>
                        @elseif($order->status === 'livree')
                            <span style="color: #28a745;">✅ Livrée</span>
                        @else
                            {{ ucfirst($order->status) }}
                        @endif
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Mode de paiement :</span>
                    <span class="detail-value">
                        @if($order->payment_method === 'en_ligne')
                            💳 Paiement en ligne
                        @else
                            💰 Paiement à la livraison
                        @endif
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Adresse de livraison :</span>
                    <span class="detail-value">{{ $order->address }}</span>
                </div>
            </div>
            
            <div class="total-section">
                <div class="detail-label">Total de votre commande</div>
                <div class="total-amount">{{ number_format($order->total, 2, ',', ' ') }} €</div>
            </div>
            
            @if($order->invoice)
                <div class="invoice-section">
                    <h3>📄 Votre facture</h3>
                    <p>Votre facture est disponible en pièce jointe de cet email.</p>
                    <p>Vous pouvez également la télécharger directement :</p>
                    <a href="{{ url('orders/'.$order->id.'/invoice') }}" class="invoice-link">
                        📥 Télécharger la facture PDF
                    </a>
                </div>
            @endif
            
            <div class="thank-you">
                Merci de votre confiance ! 🙏
            </div>
            
            <p>Nous vous tiendrons informé de l'avancement de votre commande par email. Si vous avez des questions, n'hésitez pas à nous contacter.</p>
        </div>
        
        <div class="footer">
            <p><strong>E-Commerce Premium</strong></p>
            <p>Votre partenaire de confiance pour vos achats en ligne</p>
            
            <div class="contact-info">
                <p>📧 support@ecommerce-premium.com</p>
                <p>📞 +33 1 23 45 67 89</p>
                <p>🌐 www.ecommerce-premium.com</p>
            </div>
            
            <p style="margin-top: 20px; font-size: 12px; color: #adb5bd;">
                Cet email a été envoyé automatiquement. Merci de ne pas y répondre.
            </p>
        </div>
    </div>
</body>
</html> 