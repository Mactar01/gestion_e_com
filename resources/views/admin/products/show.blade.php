@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détail du produit</h1>
    <div class="card">
        <div class="card-body">
            <h3>{{ $product->name }}</h3>
            <p><strong>Catégorie :</strong> {{ $product->category->name ?? '-' }}</p>
            <p><strong>Prix :</strong> {{ number_format($product->price, 2) }} €</p>
            <p><strong>Stock :</strong> {{ $product->stock }}</p>
            <p><strong>Description :</strong> {{ $product->description }}</p>
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="image" width="120">
            @endif
        </div>
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mt-3">Retour</a>
</div>
@endsection 