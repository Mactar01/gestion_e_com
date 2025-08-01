@extends('layouts.app')

@section('content')
<!-- Hero Section avec gradient moderne -->
<div class="hero-section text-white position-relative overflow-hidden">
    <div class="hero-background"></div>
    <div class="container position-relative">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-6">
                <h1 class="display-3 fw-bold mb-4 animate-fade-in">
                    <span class="text-gradient">Catalogue Premium</span>
                </h1>
                <p class="lead mb-4 fs-5 animate-fade-in-delay">
                    Découvrez notre collection exclusive de véhicules haut de gamme
                </p>
                <div class="stats-row animate-fade-in-delay-2">
                    <div class="stat-item">
                        <span class="stat-number">{{ $products->total() }}</span>
                        <span class="stat-label">Véhicules</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $categories->count() }}</span>
                        <span class="stat-label">Catégories</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $products->where('stock', '>', 0)->count() }}</span>
                        <span class="stat-label">Disponibles</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="search-card animate-slide-up">
                    <form method="GET" class="search-form">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="search-input-group">
                                    <i class="fas fa-search search-icon"></i>
                                    <input type="text" name="search" class="form-control search-input"
                                           placeholder="Rechercher un véhicule..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="search-input-group">
                                    <i class="fas fa-filter search-icon"></i>
                                    <select name="category" class="form-select search-select">
                                        <option value="">Toutes les catégories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @if(request('category') == $category->id) selected @endif>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-search w-100">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <!-- Résultats de recherche améliorés -->
    @if(request('search') || request('category'))
        <div class="search-results-card mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <i class="fas fa-filter text-primary me-2"></i>
                    @if(request('search'))
                        <span class="fw-bold">Recherche :</span> "{{ request('search') }}"
                    @endif
                    @if(request('category'))
                        @php $selectedCategory = $categories->find(request('category')); @endphp
                        @if($selectedCategory)
                            <span class="fw-bold ms-3">Catégorie :</span> {{ $selectedCategory->name }}
                        @endif
                    @endif
                </div>
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-times"></i> Effacer
                </a>
            </div>
        </div>
    @endif

    <!-- Grille des produits améliorée -->
    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <div class="product-card h-100">
                    <div class="product-image-container">
                        <img src="{{ $product->image }}" class="product-image" alt="{{ $product->name }}">
                        <div class="product-overlay">
                            <div class="product-actions">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-light btn-sm me-2" title="Voir détails">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm" title="Ajouter au panier">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <div class="product-badge">
                            @if($product->stock > 0)
                                <span class="badge bg-success">En stock</span>
                            @else
                                <span class="badge bg-danger">Rupture</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="product-content">
                        <div class="product-category">
                            <span class="category-tag">{{ $product->category->name }}</span>
                        </div>
                        
                        <h5 class="product-title">{{ $product->name }}</h5>
                        
                        <p class="product-description">{{ Str::limit($product->description, 80) }}</p>
                        
                        <div class="product-features">
                            <div class="feature-item">
                                <i class="fas fa-tag text-muted"></i>
                                <span>Stock: {{ $product->stock }}</span>
                            </div>
                        </div>
                        
                        <div class="product-footer">
                            <div class="price-container">
                                <span class="price-amount">{{ number_format($product->price, 0, ',', ' ') }} €</span>
                                <span class="price-label">Prix TTC</span>
                            </div>
                            
                            <div class="product-buttons">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm">
                                    Détails
                                </a>
                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-cart-plus"></i> Ajouter
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        Indisponible
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state text-center py-5">
                    <div class="empty-icon mb-4">
                        <i class="fas fa-car"></i>
                    </div>
                    <h3 class="empty-title">Aucun véhicule trouvé</h3>
                    <p class="empty-description">Essayez de modifier vos critères de recherche</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-refresh"></i> Voir tous les véhicules
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination améliorée -->
    @if($products->hasPages())
        <div class="pagination-container mt-5">
            {{ $products->links() }}
        </div>
    @endif
</div>

<style>
/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 80px 0;
    position: relative;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="rgba(255,255,255,0.1)"><polygon points="0,100 1000,0 1000,100"/></svg>');
    background-size: cover;
}

.min-vh-50 {
    min-height: 50vh;
}

.text-gradient {
    background: linear-gradient(45deg, #fff, #f8f9fa);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Animations */
.animate-fade-in {
    animation: fadeIn 1s ease-in;
}

.animate-fade-in-delay {
    animation: fadeIn 1s ease-in 0.3s both;
}

.animate-fade-in-delay-2 {
    animation: fadeIn 1s ease-in 0.6s both;
}

.animate-slide-up {
    animation: slideUp 1s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(50px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Stats Row */
.stats-row {
    display: flex;
    gap: 2rem;
    margin-top: 2rem;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: bold;
    color: #fff;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
}

/* Search Card */
.search-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.search-input-group {
    position: relative;
}

.search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    z-index: 10;
}

.search-input, .search-select {
    padding-left: 45px;
    border-radius: 10px;
    border: none;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
}

.btn-search {
    border-radius: 10px;
    padding: 12px;
}

/* Product Cards */
.product-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
}

.product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.product-image-container {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image {
    transform: scale(1.1);
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.product-actions {
    display: flex;
    gap: 10px;
}

.product-badge {
    position: absolute;
    top: 15px;
    right: 15px;
}

.product-content {
    padding: 1.5rem;
}

.product-category {
    margin-bottom: 0.5rem;
}

.category-tag {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.product-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #2c3e50;
}

.product-description {
    color: #6c757d;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1rem;
}

.product-features {
    margin-bottom: 1rem;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.85rem;
    color: #6c757d;
}

.product-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid #f0f0f0;
}

.price-container {
    text-align: left;
}

.price-amount {
    display: block;
    font-size: 1.3rem;
    font-weight: bold;
    color: #2c3e50;
}

.price-label {
    font-size: 0.8rem;
    color: #6c757d;
}

.product-buttons {
    display: flex;
    gap: 8px;
}

/* Search Results */
.search-results-card {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 1rem 1.5rem;
    border-left: 4px solid #667eea;
}

/* Empty State */
.empty-state {
    padding: 4rem 2rem;
}

.empty-icon {
    font-size: 4rem;
    color: #dee2e6;
    margin-bottom: 1rem;
}

.empty-title {
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.empty-description {
    color: #adb5bd;
    margin-bottom: 2rem;
}

/* Pagination */
.pagination-container {
    display: flex;
    justify-content: center;
}

.pagination .page-link {
    border-radius: 10px;
    margin: 0 2px;
    border: none;
    color: #667eea;
}

.pagination .page-item.active .page-link {
    background: linear-gradient(45deg, #667eea, #764ba2);
    border-color: #667eea;
}

/* Responsive */
@media (max-width: 768px) {
    .stats-row {
        flex-direction: column;
        gap: 1rem;
    }
    
    .search-card {
        padding: 1.5rem;
    }
    
    .product-card {
        margin-bottom: 1rem;
    }
}
</style>
@endsection
