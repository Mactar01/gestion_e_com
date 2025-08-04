@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">
                <i class="fas fa-list me-2"></i>Mes Commandes
            </h1>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($orders->count() > 0)
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>N° Commande</th>
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
                                            <td>
                                                <strong>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                            </td>
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="fw-bold">{{ number_format($order->total, 2, ',', ' ') }} €</td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'en attente' => 'warning',
                                                        'en cours de préparation' => 'info',
                                                        'expédiée' => 'primary',
                                                        'livrée' => 'success',
                                                        'annulée' => 'danger'
                                                    ];
                                                    $color = $statusColors[$order->status] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $color }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($order->paid)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check me-1"></i>Payé
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-clock me-1"></i>En attente
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('orders.show', $order) }}"
                                                       class="btn btn-sm btn-outline-primary"
                                                       title="Voir les détails">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    @if($order->invoice)
                                                        <a href="{{ route('orders.invoice', $order) }}"
                                                           class="btn btn-sm btn-outline-info"
                                                           title="Télécharger la facture">
                                                            <i class="fas fa-file-pdf"></i>
                                                        </a>
                                                    @endif

                                                    @if(in_array($order->status, ['en attente', 'en cours de préparation']) && !$order->paid)
                                                        <form action="{{ route('orders.cancel', $order) }}"
                                                              method="POST"
                                                              class="d-inline"
                                                              onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?')">
                                                            @csrf
                                                            <button type="submit"
                                                                    class="btn btn-sm btn-outline-danger"
                                                                    title="Annuler la commande">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-bag fa-4x text-muted mb-4"></i>
                    <h3 class="text-muted mb-3">Aucune commande</h3>
                    <p class="text-muted mb-4">Vous n'avez pas encore passé de commande.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-car me-2"></i>Découvrir nos véhicules
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
