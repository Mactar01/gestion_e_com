@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">
                <i class="fas fa-shopping-cart me-2"></i>Mon Panier
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

            @if(count($cart) > 0)
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produit</th>
                                        <th>Prix unitaire</th>
                                        <th>Quantité</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $id => $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item['image'])
                                                        <img src="{{ asset('storage/' . $item['image']) }}"
                                                             alt="{{ $item['name'] }}"
                                                             class="me-3"
                                                             style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-secondary me-3 d-flex align-items-center justify-content-center"
                                                             style="width: 50px; height: 50px;">
                                                            <i class="fas fa-car text-white"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $item['name'] }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ number_format($item['price'], 2, ',', ' ') }} €</td>
                                            <td>
                                                <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex align-items-center">
                                                    @csrf
                                                    <input type="number"
                                                           name="quantity"
                                                           value="{{ $item['quantity'] }}"
                                                           min="1"
                                                           class="form-control form-control-sm me-2"
                                                           style="width: 80px;">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="fw-bold">{{ number_format($item['price'] * $item['quantity'], 2, ',', ' ') }} €</td>
                                            <td>
                                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir retirer ce produit du panier ?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Continuer mes achats
                                </a>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h4 class="mb-3">Récapitulatif</h4>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Total :</span>
                                            <span class="fw-bold fs-5">{{ number_format($total, 2, ',', ' ') }} €</span>
                                        </div>
                                        <a href="{{ route('orders.create') }}" class="btn btn-success btn-lg w-100">
                                            <i class="fas fa-credit-card me-2"></i>Passer la commande
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                    <h3 class="text-muted mb-3">Votre panier est vide</h3>
                    <p class="text-muted mb-4">Vous n'avez pas encore ajouté de produits à votre panier.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-car me-2"></i>Découvrir nos véhicules
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
