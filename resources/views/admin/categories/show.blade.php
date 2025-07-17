@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détail de la catégorie</h1>
    <div class="card">
        <div class="card-body">
            <h3>{{ $category->name }}</h3>
            <p><strong>Description :</strong> {{ $category->description }}</p>
        </div>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary mt-3">Retour</a>
</div>
@endsection 