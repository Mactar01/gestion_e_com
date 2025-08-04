@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="search-section text-white">
<div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3">Catalogue des Voitures</h1>
                <p class="lead mb-4">Découvrez notre sélection de véhicules premium</p>
    </div>
            <div class="col-lg-6">
                <form method="GET" class="row g-3">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control form-control-lg"
                               placeholder="Rechercher une voiture..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
                        <select name="category" class="form-select form-select-lg">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if(request('category') == $category->id) selected @endif>
                                    {{ $category->name }}
                                </option>
                @endforeach
            </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-light btn-lg w-100">
                            <i class="fas fa-search"></i> Filtrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <!-- Résultats de recherche -->
    @if(request('search') || request('category'))
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            @if(request('search'))
                Recherche pour : <strong>"{{ request('search') }}"</strong>
            @endif
            @if(request('category'))
                @php $selectedCategory = $categories->find(request('category')); @endphp
                @if($selectedCategory)
                    dans la catégorie : <strong>{{ $selectedCategory->name }}</strong>
                @endif
            @endif
            <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary ms-3">Effacer les filtres</a>
        </div>
    @endif

    <!-- Grille des produits -->
    <div class="row">
        @forelse($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card product-card h-100 shadow-sm">
                    <img src="{{ $product->image }}" class="card-img-top product-image" alt="{{ $product->name }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                        <p class="card-text text-muted flex-grow-1">{{ Str::limit($product->description, 100) }}</p>

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
                            @if($product->stock > 0)
                                @auth
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="d-grid">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-shopping-cart"></i> Ajouter au panier
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary">
                                        <i class="fas fa-sign-in-alt"></i> Connectez-vous pour commander
                                    </a>
                                @endauth
                            @else
                                <button class="btn btn-secondary" disabled>
                                    <i class="fas fa-times"></i> Indisponible
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-car fa-3x text-muted mb-3"></i>
                    <h3 class="text-muted">Aucun véhicule trouvé</h3>
                    <p class="text-muted">Essayez de modifier vos critères de recherche</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Voir tous les véhicules</a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="d-flex justify-content-center mt-5">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
