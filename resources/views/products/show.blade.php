@extends('layouts.app')

@section('content')
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
            </div>
        </div>
    </div>
</div>

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
