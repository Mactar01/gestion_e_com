@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1>Débogage du Panier</h1>

            <div class="card mb-4">
                <div class="card-header">
                    <h5>État de l'authentification</h5>
                </div>
                <div class="card-body">
                    <p><strong>Utilisateur connecté :</strong> {{ auth()->check() ? 'Oui' : 'Non' }}</p>
                    @if(auth()->check())
                        <p><strong>ID utilisateur :</strong> {{ auth()->id() }}</p>
                        <p><strong>Nom utilisateur :</strong> {{ auth()->user()->name }}</p>
                        <p><strong>Email :</strong> {{ auth()->user()->email }}</p>
                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5>État de la session</h5>
                </div>
                <div class="card-body">
                    <p><strong>Session ID :</strong> {{ session()->getId() }}</p>
                    <p><strong>Contenu du panier :</strong></p>
                    <pre>{{ json_encode(session('cart'), JSON_PRETTY_PRINT) }}</pre>
                    <p><strong>Nombre d'articles dans le panier :</strong> {{ session('cart') ? count(session('cart')) : 0 }}</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5>Actions de test</h5>
                </div>
                <div class="card-body">
                    @if(auth()->check())
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Ajouter un produit de test</h6>
                                <form action="{{ route('cart.add', 1) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-success">Ajouter produit ID 1</button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <h6>Vider le panier</h6>
                                <form action="{{ route('cart.remove', 1) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Retirer produit ID 1</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <p class="text-warning">Vous devez être connecté pour tester le panier.</p>
                        <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Liens utiles</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('cart.index') }}" class="btn btn-primary me-2">Voir le panier</a>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary me-2">Catalogue</a>
                    <a href="{{ route('dashboard') }}" class="btn btn-info">Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
