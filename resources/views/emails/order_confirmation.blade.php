<h2>Merci pour votre commande !</h2>
<p>Bonjour {{ $order->user->name }},</p>
<p>Votre commande n°{{ $order->id }} a bien été enregistrée le {{ $order->created_at->format('d/m/Y H:i') }}.</p>
<p><strong>Total :</strong> {{ number_format($order->total, 2) }} €</p>
<p><strong>Adresse de livraison :</strong> {{ $order->address }}</p>
@if($order->invoice)
    <p><a href="{{ url('orders/'.$order->id.'/invoice') }}">Télécharger votre facture PDF</a></p>
@endif
<p>Merci de votre confiance !</p> 