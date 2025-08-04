@extends('layouts.app')

@section('content')
<<<<<<< HEAD
<div class="container py-4">
    <div class="row">
        <div class="col-md-6">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded shadow-sm" alt="{{ $product->name }}">
            @else
                <div class="bg-secondary d-flex align-items-center justify-content-center rounded" style="height: 400px;">
                    <i class="fas fa-car fa-6x text-white"></i>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Véhicules</a></li>
                    <li class="breadcrumb-item active">{{ $product->name }}</li>
                </ol>
            </nav>

            <h1 class="mb-3">{{ $product->name }}</h1>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Catégorie :</strong> {{ $product->category->name ?? 'Non catégorisé' }}
                        </div>
                        <div class="col-6">
                            <strong>Stock :</strong>
                            <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                {{ $product->stock > 0 ? $product->stock . ' disponible(s)' : 'Rupture de stock' }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h3 class="text-primary fw-bold">{{ number_format($product->price, 0, ',', ' ') }} €</h3>
                    </div>

                    <div class="mb-4">
                        <h5>Description :</h5>
                        <p class="text-muted">{{ $product->description }}</p>
                    </div>

                    @auth
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="mb-3">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="quantity" class="form-label">Quantité :</label>
                                        <input type="number"
                                               id="quantity"
                                               name="quantity"
                                               value="1"
                                               min="1"
                                               max="{{ $product->stock }}"
                                               class="form-control">
                                    </div>
                                    <div class="col-md-8 d-flex align-items-end">
                                        <button type="submit" class="btn btn-success btn-lg w-100">
                                            <i class="fas fa-cart-plus me-2"></i>Ajouter au panier
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Ce véhicule n'est plus disponible en stock.
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Vous devez être connecté pour ajouter des articles au panier.
                        </div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary">
                                <i class="fas fa-user-plus me-2"></i>S'inscrire
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            <div class="d-grid gap-2">
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour au catalogue
                </a>
=======
<div class="product-detail-container">
    <!-- Breadcrumb -->
    <div class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('products.index') }}" class="breadcrumb-link">
                            <i class="fas fa-home"></i> Accueil
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('products.index') }}" class="breadcrumb-link">Catalogue</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('products.index', ['category' => $product->category->id]) }}" class="breadcrumb-link">
                            {{ $product->category->name }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <!-- Image Gallery -->
            <div class="col-lg-6 mb-4">
                <div class="product-gallery">
                    <div class="main-image-container">
                        <img src="{{ $product->image }}" class="main-image" alt="{{ $product->name }}" id="mainImage">
                        <div class="image-overlay">
                            <div class="zoom-controls">
                                <button class="btn btn-light btn-sm" onclick="zoomIn()">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                                <button class="btn btn-light btn-sm" onclick="zoomOut()">
                                    <i class="fas fa-search-minus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stock Badge -->
                    <div class="stock-badge">
                        @if($product->stock > 0)
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle"></i> En stock ({{ $product->stock }})
                            </span>
                        @else
                            <span class="badge bg-danger">
                                <i class="fas fa-times-circle"></i> Rupture de stock
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="product-info">
                    <!-- Category Tag -->
                    <div class="category-badge mb-3">
                        <span class="category-tag">{{ $product->category->name }}</span>
                    </div>

                    <!-- Product Title -->
                    <h1 class="product-title mb-3">{{ $product->name }}</h1>

                    <!-- Price Section -->
                    <div class="price-section mb-4">
                        <div class="price-main">
                            <span class="price-amount">{{ number_format($product->price, 0, ',', ' ') }} €</span>
                            <span class="price-label">Prix TTC</span>
                        </div>
                        <div class="price-details">
                            <small class="text-muted">Prix HT: {{ number_format($product->price / 1.2, 0, ',', ' ') }} €</small>
                        </div>
                    </div>

                    <!-- Product Description -->
                    <div class="description-section mb-4">
                        <h5 class="section-title">
                            <i class="fas fa-info-circle text-primary"></i> Description
                        </h5>
                        <p class="product-description">{{ $product->description }}</p>
                    </div>

                    <!-- Product Features -->
                    <div class="features-section mb-4">
                        <h5 class="section-title">
                            <i class="fas fa-list-check text-primary"></i> Caractéristiques
                        </h5>
                        <div class="features-grid">
                            <div class="feature-item">
                                <i class="fas fa-tag text-muted"></i>
                                <span>Catégorie: {{ $product->category->name }}</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-boxes text-muted"></i>
                                <span>Stock: {{ $product->stock }} unités</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-calendar text-muted"></i>
                                <span>Ajouté le: {{ $product->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Add to Cart Section -->
                    @if($product->stock > 0)
                        <div class="cart-section mb-4">
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="cart-form">
                                @csrf
                                <div class="quantity-selector">
                                    <label for="quantity" class="form-label">Quantité:</label>
                                    <div class="quantity-controls">
                                        <button type="button" class="btn btn-outline-secondary" onclick="decreaseQuantity()">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control quantity-input">
                                        <button type="button" class="btn btn-outline-secondary" onclick="increaseQuantity()">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="cart-actions">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                        <i class="fas fa-shopping-cart"></i> Ajouter au panier
                                    </button>
                                    
                                    <div class="secondary-actions">
                                        <a href="{{ route('cart.index') }}" class="btn btn-outline-primary">
                                            <i class="fas fa-eye"></i> Voir le panier
                                        </a>
                                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-arrow-left"></i> Continuer les achats
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="out-of-stock-section mb-4">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                Ce produit est actuellement en rupture de stock.
                            </div>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left"></i> Retour au catalogue
                            </a>
                        </div>
                    @endif

                    <!-- Related Products -->
                    <div class="related-products-section">
                        <h5 class="section-title">
                            <i class="fas fa-car text-primary"></i> Produits similaires
                        </h5>
                        <div class="related-products">
                            @php
                                $relatedProducts = \App\Models\Product::where('category_id', $product->category_id)
                                    ->where('id', '!=', $product->id)
                                    ->limit(3)
                                    ->get();
                            @endphp
                            
                            @forelse($relatedProducts as $relatedProduct)
                                <div class="related-product-item">
                                    <img src="{{ $relatedProduct->image }}" alt="{{ $relatedProduct->name }}" class="related-product-image">
                                    <div class="related-product-info">
                                        <h6>{{ $relatedProduct->name }}</h6>
                                        <p class="related-product-price">{{ number_format($relatedProduct->price, 0, ',', ' ') }} €</p>
                                        <a href="{{ route('products.show', $relatedProduct) }}" class="btn btn-sm btn-outline-primary">
                                            Voir
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">Aucun produit similaire trouvé.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
>>>>>>> 67797e28225dc09dffa7355be39ecd45881ad812
            </div>
        </div>
    </div>
</div>

<<<<<<< HEAD
@if(session('success'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div class="toast show" role="alert">
            <div class="toast-header bg-success text-white">
                <i class="fas fa-check-circle me-2"></i>
                <strong class="me-auto">Succès</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                {{ session('success') }}
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div class="toast show" role="alert">
            <div class="toast-header bg-danger text-white">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong class="me-auto">Erreur</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                {{ session('error') }}
            </div>
        </div>
    </div>
@endif
@endsection
=======
<style>
/* Product Detail Styles */
.product-detail-container {
    background: #f8f9fa;
    min-height: 100vh;
}

/* Breadcrumb */
.breadcrumb-section {
    background: #fff;
    padding: 1rem 0;
    border-bottom: 1px solid #e9ecef;
}

.breadcrumb {
    background: none;
    padding: 0;
    margin: 0;
}

.breadcrumb-link {
    color: #667eea;
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb-link:hover {
    color: #764ba2;
}

.breadcrumb-item.active {
    color: #6c757d;
}

/* Product Gallery */
.product-gallery {
    position: relative;
}

.main-image-container {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    background: #fff;
}

.main-image {
    width: 100%;
    height: 400px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.image-overlay {
    position: absolute;
    top: 15px;
    right: 15px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.main-image-container:hover .image-overlay {
    opacity: 1;
}

.zoom-controls {
    display: flex;
    gap: 8px;
}

.stock-badge {
    position: absolute;
    top: 15px;
    left: 15px;
}

/* Product Info */
.product-info {
    background: #fff;
    padding: 2rem;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.category-badge {
    display: inline-block;
}

.category-tag {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    padding: 6px 16px;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 500;
}

.product-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    line-height: 1.2;
}

/* Price Section */
.price-section {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 1.5rem;
    border-radius: 15px;
    border-left: 4px solid #667eea;
}

.price-main {
    display: flex;
    align-items: baseline;
    gap: 10px;
    margin-bottom: 0.5rem;
}

.price-amount {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
}

.price-label {
    font-size: 1rem;
    color: #6c757d;
}

.price-details {
    font-size: 0.9rem;
}

/* Sections */
.section-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

.product-description {
    color: #6c757d;
    line-height: 1.6;
    font-size: 1rem;
}

/* Features Grid */
.features-grid {
    display: grid;
    gap: 1rem;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 10px;
    font-size: 0.95rem;
}

.feature-item i {
    width: 20px;
    text-align: center;
}

/* Cart Section */
.cart-section {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 15px;
}

.quantity-selector {
    margin-bottom: 1.5rem;
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 10px;
    max-width: 200px;
}

.quantity-input {
    text-align: center;
    border-radius: 10px;
}

.cart-actions {
    text-align: center;
}

.secondary-actions {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin-top: 1rem;
}

/* Related Products */
.related-products-section {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #e9ecef;
}

.related-products {
    display: grid;
    gap: 1rem;
    margin-top: 1rem;
}

.related-product-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 10px;
    transition: transform 0.3s ease;
}

.related-product-item:hover {
    transform: translateX(5px);
}

.related-product-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 10px;
}

.related-product-info {
    flex: 1;
}

.related-product-info h6 {
    margin: 0;
    font-size: 0.95rem;
    color: #2c3e50;
}

.related-product-price {
    margin: 0;
    font-size: 0.9rem;
    color: #667eea;
    font-weight: 600;
}

/* Out of Stock */
.out-of-stock-section {
    text-align: center;
}

/* Responsive */
@media (max-width: 768px) {
    .product-title {
        font-size: 2rem;
    }
    
    .price-amount {
        font-size: 2rem;
    }
    
    .product-info {
        padding: 1.5rem;
    }
    
    .secondary-actions {
        flex-direction: column;
    }
    
    .related-product-item {
        flex-direction: column;
        text-align: center;
    }
}
</style>

<script>
let currentZoom = 1;
const zoomStep = 0.2;
const maxZoom = 3;
const minZoom = 0.5;

function zoomIn() {
    if (currentZoom < maxZoom) {
        currentZoom += zoomStep;
        updateZoom();
    }
}

function zoomOut() {
    if (currentZoom > minZoom) {
        currentZoom -= zoomStep;
        updateZoom();
    }
}

function updateZoom() {
    const mainImage = document.getElementById('mainImage');
    mainImage.style.transform = `scale(${currentZoom})`;
}

function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
        quantityInput.value = currentValue - 1;
    }
}

function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    const maxValue = parseInt(quantityInput.max);
    if (currentValue < maxValue) {
        quantityInput.value = currentValue + 1;
    }
}
</script>
@endsection 
>>>>>>> 67797e28225dc09dffa7355be39ecd45881ad812
