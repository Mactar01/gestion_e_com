@extends('layouts.admin')

@section('title', 'Gestion des Véhicules')
@section('page-title', 'Gestion des Véhicules')

@section('content')
<div class="fade-in">
    <!-- Header avec bouton d'ajout -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Véhicules</h2>
            <p class="text-muted mb-0">Gérez votre inventaire de véhicules</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary-custom">
            <i class="fas fa-plus me-2"></i>Ajouter un véhicule
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card position-relative">
                <div class="stats-number">{{ $products->total() }}</div>
                <div class="stats-label">Total Véhicules</div>
                <i class="fas fa-car stats-icon text-primary"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card position-relative">
                <div class="stats-number">{{ $products->where('stock', '>', 0)->count() }}</div>
                <div class="stats-label">En Stock</div>
                <i class="fas fa-check-circle stats-icon text-success"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card position-relative">
                <div class="stats-number">{{ $products->where('stock', '<=', 5)->count() }}</div>
                <div class="stats-label">Stock Faible</div>
                <i class="fas fa-exclamation-triangle stats-icon text-warning"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card position-relative">
                <div class="stats-number">{{ number_format($products->avg('price'), 0) }}€</div>
                <div class="stats-label">Prix Moyen</div>
                <i class="fas fa-euro-sign stats-icon text-info"></i>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="admin-card">
        <div class="card-header-custom">
            <h4><i class="fas fa-car me-2"></i>Inventaire des Véhicules</h4>
        </div>
        <div class="card-body p-4">
            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-12 col-sm-6 col-md-4 col-xl-3 mb-4">
                            <div class="admin-card h-100 position-relative">
                                <!-- Stock Badge -->
                                @if($product->stock <= 5)
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-warning">
                                            <i class="fas fa-exclamation-triangle me-1"></i>Stock faible
                                        </span>
                                    </div>
                                @endif
                                
                                <!-- Image -->
                                <div class="position-relative overflow-hidden" style="height: 200px; border-radius: 15px 15px 0 0;">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             class="w-100 h-100" 
                                             alt="{{ $product->name }}" 
                                             style="object-fit: cover;">
                                    @else
                                        <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                            <div class="text-center text-muted">
                                                <i class="fas fa-car fa-3x mb-2"></i>
                                                <p class="mb-0">Pas d'image</p>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <!-- Overlay with quick actions -->
                                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center opacity-0 hover-overlay" 
                                         style="background: rgba(0,0,0,0.7); transition: opacity 0.3s ease;">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.products.show', $product) }}" 
                                               class="btn btn-light btn-sm" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product) }}" 
                                               class="btn btn-warning btn-sm" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Content -->
                                <div class="p-3">
                                    <h6 class="mb-2 fw-bold">{{ Str::limit($product->name, 25) }}</h6>
                                    
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-tag me-1"></i>
                                            {{ $product->category->name ?? 'Sans catégorie' }}
                                        </small>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="h6 text-primary mb-0">{{ number_format($product->price, 0) }}€</span>
                                        <span class="badge {{ $product->stock > 5 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                                            Stock: {{ $product->stock }}
                                        </span>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="d-flex gap-2 mt-3">
                                        <a href="{{ route('admin.products.edit', $product) }}" 
                                           class="btn btn-outline-warning btn-sm flex-fill">
                                            <i class="fas fa-edit me-1"></i>Modifier
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" 
                                              method="POST" class="flex-fill"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                                <i class="fas fa-trash me-1"></i>Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-car fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucun véhicule trouvé</h5>
                    <p class="text-muted mb-4">Commencez par ajouter votre premier véhicule à l'inventaire</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary-custom">
                        <i class="fas fa-plus me-2"></i>Ajouter un véhicule
                    </a>
                </div>
            @endif
        </div>
        
        @if($products->hasPages())
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.admin-card:hover .hover-overlay {
    opacity: 1 !important;
}
</style>
@endsection 