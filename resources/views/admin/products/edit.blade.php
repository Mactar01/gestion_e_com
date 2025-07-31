@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le produit</h1>
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Catégorie</label>
            <select name="category_id" class="form-control" required>
                <option value="">Sélectionner</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if(($product->category_id ?? null) == $category->id) selected @endif>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Prix</label>
            <input type="number" name="price" class="form-control" step="0.01" value="{{ old('price', $product->price) }}" required>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" class="form-control">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="image" width="80" class="mt-2">
            @endif
        </div>
        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection 