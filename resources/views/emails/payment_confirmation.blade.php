<h2>Paiement confirmé</h2>
<p>Bonjour {{ $order->user->name ?? '-' }},</p>
<p>Nous confirmons la réception du paiement pour votre commande n°{{ $order->id }}.</p>
<p><strong>Total :</strong> {{ number_format($order->total, 2) }} €</p>
<p>Merci de votre confiance !</p> 