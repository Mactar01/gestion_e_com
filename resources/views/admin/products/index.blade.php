@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Gestion des Voitures à Vendre</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-4">Ajouter une voiture</a>
    <div class="row">
        @forelse($products as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="image voiture" style="object-fit:cover; height:180px;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height:180px;">
                            <span class="text-muted">Pas d'image</span>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text mb-1"><strong>Catégorie :</strong> {{ $product->category->name ?? '-' }}</p>
                        <p class="card-text mb-1"><strong>Prix :</strong> {{ number_format($product->price, 2) }} €</p>
                        <p class="card-text mb-2"><strong>Stock :</strong> {{ $product->stock }}</p>
                        <div class="mt-auto d-flex justify-content-between">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette voiture ?')">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">Aucune voiture enregistrée pour le moment.</div>
            </div>
        @endforelse
    </div>
    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection 