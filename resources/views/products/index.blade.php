@extends('layouts.app')

@section('content')
<div class="container">
    {{-- DEBUG TEMPORAIRE --}}
    <div class="alert alert-warning">
        Utilisateur connecté : <strong>{{ Auth::user()->name ?? 'Aucun' }}</strong><br>
        Nombre de produits récupérés : <strong>{{ $products->count() }}</strong>
    </div>
    {{-- DEBUG ULTIME --}}
    <div class="alert alert-danger">
        <strong>DEBUG PRODUITS :</strong>
        <ul>
            @foreach($products as $p)
                <li>ID: {{ $p->id }} | Nom: {{ $p->name }} | Catégorie: {{ $p->category_id }}</li>
            @endforeach
        </ul>
    </div>
    <h1 class="mb-4">Catalogue des Voitures à Vendre</h1>
    <!-- DEBUG : Affichage du nombre de produits et de leurs noms -->
    <div class="alert alert-warning">
        <strong>Debug :</strong> Nombre de produits récupérés : {{ $products->count() }}<br>
        @foreach($products as $p)
            - {{ $p->name }}<br>
        @endforeach
    </div>
    <form method="GET" class="row mb-4">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Recherche..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <select name="category" class="form-control">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if(request('category') == $category->id) selected @endif>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary w-100">Filtrer</button>
        </div>
    </form>
    <div class="row">
        @forelse($products as $product)
            <div class="col-12 col-sm-6 col-md-4 mb-4">
                <div class="alert alert-success">Nom du produit : {{ $product->name }}</div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">Aucun produit trouvé.</div>
            </div>
        @endforelse
    </div>
    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection 