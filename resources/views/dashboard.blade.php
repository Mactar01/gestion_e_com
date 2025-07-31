@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3">Bienvenue sur AutoPremium</h1>
                <p class="lead mb-4">Découvrez notre sélection de véhicules premium et trouvez la voiture de vos rêves.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-car me-2"></i>Voir nos véhicules
                    </a>
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-shopping-cart me-2"></i>Mon panier
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-car fa-8x opacity-75"></i>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <!-- Statistiques rapides -->
    <div class="row mb-5">
        <div class="col-md-3 text-center">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-car fa-3x text-primary mb-3"></i>
                    <h4 class="fw-bold">{{ \App\Models\Product::count() }}</h4>
                    <p class="text-muted">Véhicules disponibles</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-tags fa-3x text-success mb-3"></i>
                    <h4 class="fw-bold">{{ \App\Models\Category::count() }}</h4>
                    <p class="text-muted">Catégories</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-users fa-3x text-info mb-3"></i>
                    <h4 class="fw-bold">{{ \App\Models\User::count() }}</h4>
                    <p class="text-muted">Clients satisfaits</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-shipping-fast fa-3x text-warning mb-3"></i>
                    <h4 class="fw-bold">24h</h4>
                    <p class="text-muted">Livraison rapide</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Derniers produits -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="fw-bold mb-4">Nos derniers véhicules</h2>
        </div>
        @foreach(\App\Models\Product::latest()->take(4)->get() as $product)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card product-card h-100 shadow-sm">
                    <img src="{{ $product->image }}" class="card-img-top product-image" alt="{{ $product->name }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                        <p class="card-text text-muted flex-grow-1">{{ Str::limit($product->description, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="price-tag">{{ number_format($product->price, 0, ',', ' ') }} €</span>
                            <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                {{ $product->stock > 0 ? 'En stock' : 'Rupture' }}
                            </span>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary">
                                <i class="fas fa-eye"></i> Voir détails
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Catégories -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="fw-bold mb-4">Nos catégories</h2>
        </div>
        @foreach(\App\Models\Category::all() as $category)
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-car fa-3x text-primary mb-3"></i>
                        <h5 class="card-title fw-bold">{{ $category->name }}</h5>
                        <p class="card-text text-muted">{{ $category->description }}</p>
                        <a href="{{ route('products.index', ['category' => $category->id]) }}" class="btn btn-primary">
                            Voir les véhicules
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Call to Action -->
    <div class="row">
        <div class="col-12">
            <div class="card bg-primary text-white text-center">
                <div class="card-body py-5">
                    <h3 class="fw-bold mb-3">Prêt à trouver votre véhicule idéal ?</h3>
                    <p class="lead mb-4">Parcourez notre catalogue complet et trouvez la voiture qui vous correspond.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-search me-2"></i>Explorer le catalogue
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
