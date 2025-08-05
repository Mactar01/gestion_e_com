@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="fade-in">
    <!-- Stats Cards Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card position-relative">
                <div class="stats-number">{{ $stats['total_products'] ?? 0 }}</div>
                <div class="stats-label">Véhicules</div>
                <i class="fas fa-car stats-icon text-primary"></i>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card position-relative">
                <div class="stats-number">{{ $stats['total_orders'] ?? 0 }}</div>
                <div class="stats-label">Commandes</div>
                <i class="fas fa-shopping-cart stats-icon text-success"></i>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card position-relative">
                <div class="stats-number">{{ $stats['total_users'] ?? 0 }}</div>
                <div class="stats-label">Clients</div>
                <i class="fas fa-users stats-icon text-info"></i>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card position-relative">
                <div class="stats-number">{{ number_format($stats['total_revenue'] ?? 0, 0) }}€</div>
                <div class="stats-label">Chiffre d'affaires</div>
                <i class="fas fa-euro-sign stats-icon text-warning"></i>
            </div>
        </div>
    </div>
    
    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-xl-8 mb-4">
            <div class="admin-card">
                <div class="card-header-custom">
                    <h4><i class="fas fa-chart-line me-2"></i>Évolution des Ventes</h4>
                </div>
                <div class="card-body p-4">
                    <canvas id="salesChart" height="100"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 mb-4">
            <div class="admin-card">
                <div class="card-header-custom">
                    <h4><i class="fas fa-chart-pie me-2"></i>Répartition par Catégorie</h4>
                </div>
                <div class="card-body p-4">
                    <canvas id="categoryChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity Row -->
    <div class="row">
        <div class="col-xl-8 mb-4">
            <div class="admin-card">
                <div class="card-header-custom">
                    <h4><i class="fas fa-clock me-2"></i>Commandes Récentes</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Commande</th>
                                    <th>Client</th>
                                    <th>Date</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_orders ?? [] as $order)
                                <tr>
                                    <td><strong>#{{ $order->id }}</strong></td>
                                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td><strong>{{ number_format($order->total, 2) }}€</strong></td>
                                    <td>
                                        @switch($order->status)
                                            @case('pending')
                                                <span class="badge bg-warning">En attente</span>
                                                @break
                                            @case('confirmed')
                                                <span class="badge bg-info">Confirmée</span>
                                                @break
                                            @case('shipped')
                                                <span class="badge bg-primary">Expédiée</span>
                                                @break
                                            @case('delivered')
                                                <span class="badge bg-success">Livrée</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge bg-danger">Annulée</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-2x mb-3 d-block"></i>
                                        Aucune commande récente
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 mb-4">
            <div class="admin-card">
                <div class="card-header-custom">
                    <h4><i class="fas fa-exclamation-triangle me-2"></i>Stock Faible</h4>
                </div>
                <div class="card-body">
                    @forelse($low_stock_products ?? [] as $product)
                    <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                        <div class="flex-shrink-0">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                     class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-car text-white"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ Str::limit($product->name, 20) }}</h6>
                            <small class="text-danger">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                Stock: {{ $product->stock }}
                            </small>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-check-circle fa-2x mb-3 d-block text-success"></i>
                        Tous les stocks sont OK
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="admin-card">
                <div class="card-header-custom">
                    <h4><i class="fas fa-bolt me-2"></i>Actions Rapides</h4>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary-custom w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="min-height: 120px;">
                                <i class="fas fa-plus-circle fa-2x mb-2"></i>
                                <span>Ajouter un Véhicule</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-success w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="min-height: 120px;">
                                <i class="fas fa-tags fa-2x mb-2"></i>
                                <span>Nouvelle Catégorie</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-info w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="min-height: 120px;">
                                <i class="fas fa-list fa-2x mb-2"></i>
                                <span>Gérer Commandes</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="min-height: 120px;">
                                <i class="fas fa-users fa-2x mb-2"></i>
                                <span>Gérer Utilisateurs</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: @json($chart_data['sales_labels'] ?? ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun']),
            datasets: [{
                label: 'Ventes (€)',
                data: @json($chart_data['sales_data'] ?? [1200, 1900, 3000, 5000, 2300, 3200]),
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
    
    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: @json($chart_data['category_labels'] ?? ['Berline', 'SUV', 'Sportive', 'Utilitaire']),
            datasets: [{
                data: @json($chart_data['category_data'] ?? [30, 25, 20, 25]),
                backgroundColor: [
                    '#667eea',
                    '#764ba2',
                    '#48bb78',
                    '#ed8936'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });
});
</script>
@endpush
