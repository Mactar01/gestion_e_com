@extends('layouts.admin')

@section('title', 'Gestion des Commandes')
@section('page-title', 'Gestion des Commandes')

@section('content')
<div class="fade-in">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Commandes</h2>
            <p class="text-muted mb-0">Gérez toutes les commandes de votre boutique</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="fas fa-filter me-2"></i>Filtres
            </button>
            <a href="{{ route('admin.orders.export') }}" class="btn btn-success">
                <i class="fas fa-download me-2"></i>Exporter
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card position-relative">
                <div class="stats-number">{{ $orders->total() }}</div>
                <div class="stats-label">Total Commandes</div>
                <i class="fas fa-shopping-cart stats-icon text-primary"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card position-relative">
                <div class="stats-number">{{ $orders->where('status', 'pending')->count() }}</div>
                <div class="stats-label">En Attente</div>
                <i class="fas fa-clock stats-icon text-warning"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card position-relative">
                <div class="stats-number">{{ $orders->where('status', 'delivered')->count() }}</div>
                <div class="stats-label">Livrées</div>
                <i class="fas fa-check-circle stats-icon text-success"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card position-relative">
                <div class="stats-number">{{ number_format($orders->sum('total'), 0) }}€</div>
                <div class="stats-label">Chiffre d'Affaires</div>
                <i class="fas fa-euro-sign stats-icon text-info"></i>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="admin-card">
        <div class="card-header-custom">
            <h4><i class="fas fa-list me-2"></i>Liste des Commandes</h4>
        </div>
        <div class="card-body p-0">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="admin-table table mb-0">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag me-2"></i>Commande</th>
                                <th><i class="fas fa-user me-2"></i>Client</th>
                                <th><i class="fas fa-calendar me-2"></i>Date</th>
                                <th><i class="fas fa-euro-sign me-2"></i>Montant</th>
                                <th><i class="fas fa-info-circle me-2"></i>Statut</th>
                                <th><i class="fas fa-credit-card me-2"></i>Paiement</th>
                                <th><i class="fas fa-cogs me-2"></i>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-shopping-cart text-white"></i>
                                            </div>
                                            <div>
                                                <strong>#{{ $order->id }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $order->user->name ?? 'Client supprimé' }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $order->user->email ?? '-' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $order->created_at->format('d/m/Y') }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="h6 text-primary mb-0">{{ number_format($order->total, 2) }}€</span>
                                    </td>
                                    <td>
                                        @switch($order->status)
                                            @case('pending')
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-clock me-1"></i>En attente
                                                </span>
                                                @break
                                            @case('confirmed')
                                                <span class="badge bg-info">
                                                    <i class="fas fa-check me-1"></i>Confirmée
                                                </span>
                                                @break
                                            @case('shipped')
                                                <span class="badge bg-primary">
                                                    <i class="fas fa-truck me-1"></i>Expédiée
                                                </span>
                                                @break
                                            @case('delivered')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i>Livrée
                                                </span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times me-1"></i>Annulée
                                                </span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        @if($order->paid)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Payé
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times-circle me-1"></i>Non payé
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.orders.show', $order) }}" 
                                               class="btn btn-sm btn-outline-info" title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.orders.edit', $order) }}" 
                                               class="btn btn-sm btn-outline-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                        data-bs-toggle="dropdown" title="Plus d'actions">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>Imprimer facture</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i>Envoyer email</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-ban me-2"></i>Annuler commande</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucune commande trouvée</h5>
                    <p class="text-muted mb-4">Les commandes apparaîtront ici une fois que les clients commenceront à acheter</p>
                </div>
            @endif
        </div>
        
        @if($orders->hasPages())
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Affichage de {{ $orders->firstItem() }} à {{ $orders->lastItem() }} sur {{ $orders->total() }} commandes
                    </div>
                    <div>
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-filter me-2"></i>Filtrer les commandes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="GET">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Statut</label>
                            <select name="status" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="pending">En attente</option>
                                <option value="confirmed">Confirmée</option>
                                <option value="shipped">Expédiée</option>
                                <option value="delivered">Livrée</option>
                                <option value="cancelled">Annulée</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Paiement</label>
                            <select name="paid" class="form-select">
                                <option value="">Tous</option>
                                <option value="1">Payé</option>
                                <option value="0">Non payé</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date de début</label>
                            <input type="date" name="date_from" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date de fin</label>
                            <input type="date" name="date_to" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Appliquer les filtres</button>
            </div>
        </div>
    </div>
</div>
@endsection 