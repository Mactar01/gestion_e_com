@extends('layouts.admin')

@section('title', 'Gestion des Catégories')
@section('page-title', 'Gestion des Catégories')

@section('content')
<div class="fade-in">
    <!-- Header avec bouton d'ajout -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Catégories</h2>
            <p class="text-muted mb-0">Gérez les catégories de véhicules</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary-custom">
            <i class="fas fa-plus me-2"></i>Ajouter une catégorie
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stats-card position-relative">
                <div class="stats-number">{{ $categories->total() }}</div>
                <div class="stats-label">Total Catégories</div>
                <i class="fas fa-tags stats-icon text-primary"></i>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card position-relative">
                <div class="stats-number">{{ $categories->where('products_count', '>', 0)->count() }}</div>
                <div class="stats-label">Avec Produits</div>
                <i class="fas fa-check-circle stats-icon text-success"></i>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card position-relative">
                <div class="stats-number">{{ $categories->sum('products_count') }}</div>
                <div class="stats-label">Total Véhicules</div>
                <i class="fas fa-car stats-icon text-info"></i>
            </div>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="admin-card">
        <div class="card-header-custom">
            <h4><i class="fas fa-list me-2"></i>Liste des Catégories</h4>
        </div>
        <div class="card-body p-0">
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="admin-table table mb-0">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag me-2"></i>ID</th>
                                <th><i class="fas fa-tag me-2"></i>Nom</th>
                                <th><i class="fas fa-align-left me-2"></i>Description</th>
                                <th><i class="fas fa-car me-2"></i>Véhicules</th>
                                <th><i class="fas fa-calendar me-2"></i>Créée le</th>
                                <th><i class="fas fa-cogs me-2"></i>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td><strong>#{{ $category->id }}</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-tag text-white"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $category->name }}</strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ Str::limit($category->description ?? 'Aucune description', 50) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $category->products_count ?? 0 }} véhicules</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ $category->created_at->format('d/m/Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.categories.show', $category) }}" 
                                               class="btn btn-sm btn-outline-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.categories.edit', $category) }}" 
                                               class="btn btn-sm btn-outline-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" 
                                                  method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucune catégorie trouvée</h5>
                    <p class="text-muted mb-4">Commencez par créer votre première catégorie</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary-custom">
                        <i class="fas fa-plus me-2"></i>Créer une catégorie
                    </a>
                </div>
            @endif
        </div>
        
        @if($categories->hasPages())
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-center">
                    {{ $categories->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 