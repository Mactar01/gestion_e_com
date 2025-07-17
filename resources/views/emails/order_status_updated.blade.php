<h2>Statut de votre commande mis à jour</h2>
<p>Bonjour {{ $order->user->name }},</p>
<p>Le statut de votre commande n°{{ $order->id }} est désormais : <strong>{{ ucfirst($order->status) }}</strong>.</p>
<p>Merci de votre confiance !</p> 