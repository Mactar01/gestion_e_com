@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" alt="image produit">
            @endif
        </div>
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <p><strong>Catégorie :</strong> {{ $product->category->name ?? '-' }}</p>
            <p><strong>Prix :</strong> {{ number_format($product->price, 2) }} €</p>
            <p><strong>Stock :</strong> {{ $product->stock }}</p>
            <p>{{ $product->description }}</p>
            <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-3">
                @csrf
                <div class="input-group mb-3" style="max-width: 200px;">
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control">
                    <button type="submit" class="btn btn-success">Ajouter au panier</button>
                </div>
            </form>
            <a href="{{ route('products.index') }}" class="btn btn-secondary mt-2">Retour au catalogue</a>
        </div>
    </div>
</div>
@endsection 