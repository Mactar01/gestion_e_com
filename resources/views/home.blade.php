@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-background"></div>
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1 class="hero-title">
                        <span class="text-gradient">Votre Concessionnaire</span><br>
                        <span class="text-white">de Confiance</span>
                    </h1>
                    <p class="hero-subtitle">
                        Découvrez notre sélection exclusive de véhicules premium. 
                        Qualité, fiabilité et excellence au service de votre mobilité.
                    </p>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <div class="stat-number">{{ $stats['total_vehicles'] ?? '150+' }}</div>
                            <div class="stat-label">Véhicules</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ $stats['happy_clients'] ?? '500+' }}</div>
                            <div class="stat-label">Clients Satisfaits</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ $stats['years_experience'] ?? '15+' }}</div>
                            <div class="stat-label">Ans d'Expérience</div>
                        </div>
                    </div>
                    <div class="hero-actions">
                        <a href="{{ route('products.index') }}" class="btn btn-primary-custom btn-lg me-3">
                            <i class="fas fa-car me-2"></i>Voir nos Véhicules
                        </a>
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg me-2">
                                <i class="fas fa-sign-in-alt me-2"></i>Se Connecter
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                                <i class="fas fa-user-plus me-2"></i>S'inscrire
                            </a>
                        @else
                            <a href="#about" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-info-circle me-2"></i>En savoir plus
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image">
                    <div class="floating-card">
                        <div class="card-content">
                            <i class="fas fa-award text-primary mb-3"></i>
                            <h5>Garantie Premium</h5>
                            <p>Tous nos véhicules sont garantis et certifiés</p>
                        </div>
                    </div>
                    <div class="floating-card floating-card-2">
                        <div class="card-content">
                            <i class="fas fa-handshake text-success mb-3"></i>
                            <h5>Service Client</h5>
                            <p>Accompagnement personnalisé 7j/7</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="scroll-indicator">
        <a href="#features" class="scroll-down">
            <i class="fas fa-chevron-down"></i>
        </a>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="features-section py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title">Pourquoi Nous Choisir ?</h2>
                <p class="section-subtitle">Des services d'excellence pour votre satisfaction</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4>Véhicules Certifiés</h4>
                    <p>Tous nos véhicules passent par un contrôle qualité rigoureux de 120 points avant mise en vente.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h4>Service Après-Vente</h4>
                    <p>Atelier équipé des dernières technologies avec des techniciens certifiés constructeurs.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h4>Financement Flexible</h4>
                    <p>Solutions de financement adaptées à votre budget avec nos partenaires bancaires.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <h4>Reprise Véhicule</h4>
                    <p>Estimation gratuite et reprise de votre ancien véhicule au meilleur prix du marché.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h4>Livraison Gratuite</h4>
                    <p>Livraison gratuite dans un rayon de 50km et possibilité de livraison partout en France.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h4>Support 24/7</h4>
                    <p>Assistance téléphonique disponible 24h/24 et 7j/7 pour tous vos besoins.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Vehicles Section -->
<section class="featured-vehicles py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title">Véhicules en Vedette</h2>
                <p class="section-subtitle">Découvrez notre sélection coup de cœur</p>
            </div>
        </div>
        <div class="row g-4">
            @forelse($featured_products ?? [] as $product)
            <div class="col-lg-4 col-md-6">
                <div class="vehicle-card">
                    <div class="vehicle-image">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                        @else
                            <div class="no-image">
                                <i class="fas fa-car"></i>
                            </div>
                        @endif
                        <div class="vehicle-overlay">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-light">
                                <i class="fas fa-eye me-2"></i>Voir Détails
                            </a>
                        </div>
                    </div>
                    <div class="vehicle-content">
                        <h5>{{ $product->name }}</h5>
                        <p class="text-muted">{{ $product->category->name ?? 'Véhicule' }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price">{{ number_format($product->price, 0) }}€</span>
                            <span class="badge bg-success">Disponible</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">Aucun véhicule en vedette pour le moment.</p>
            </div>
            @endforelse
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('products.index') }}" class="btn btn-primary-custom btn-lg">
                <i class="fas fa-th-large me-2"></i>Voir Tous les Véhicules
            </a>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="about-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-content">
                    <h2 class="section-title text-start">À Propos de Nous</h2>
                    <p class="lead">
                        Depuis plus de 15 ans, nous sommes votre partenaire de confiance dans l'achat et la vente de véhicules d'occasion premium.
                    </p>
                    <p>
                        Notre expertise et notre passion pour l'automobile nous permettent de vous proposer une sélection rigoureuse de véhicules de qualité, 
                        accompagnée d'un service client exceptionnel.
                    </p>
                    <div class="about-features">
                        <div class="about-feature">
                            <i class="fas fa-check-circle text-success me-3"></i>
                            <span>Contrôle qualité rigoureux</span>
                        </div>
                        <div class="about-feature">
                            <i class="fas fa-check-circle text-success me-3"></i>
                            <span>Garantie constructeur respectée</span>
                        </div>
                        <div class="about-feature">
                            <i class="fas fa-check-circle text-success me-3"></i>
                            <span>Prix transparents et compétitifs</span>
                        </div>
                        <div class="about-feature">
                            <i class="fas fa-check-circle text-success me-3"></i>
                            <span>Service après-vente de qualité</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-image">
                    <div class="image-placeholder">
                        <i class="fas fa-building fa-5x text-primary"></i>
                        <h4 class="mt-3">Notre Concession</h4>
                        <p>Un espace moderne dédié à votre confort</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <h2 class="text-white mb-4">Prêt à Trouver Votre Véhicule Idéal ?</h2>
                <p class="text-white-50 mb-4 lead">
                    Parcourez notre catalogue en ligne ou visitez notre showroom pour découvrir nos véhicules d'exception.
                </p>
                <div class="cta-actions">
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg me-3">
                        <i class="fas fa-search me-2"></i>Parcourir le Catalogue
                    </a>
                    <a href="#contact" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-phone me-2"></i>Nous Contacter
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
:root {
    --primary-color: #667eea;
    --primary-dark: #5a67d8;
    --secondary-color: #764ba2;
    --success-color: #48bb78;
    --warning-color: #ed8936;
    --danger-color: #f56565;
}

/* Navigation Enhancement */
.navbar {
    z-index: 1050 !important;
    backdrop-filter: blur(10px);
    background: rgba(102, 126, 234, 0.95) !important;
}

.navbar .nav-link {
    font-weight: 500;
    transition: all 0.3s ease;
}

.navbar .nav-link:hover {
    transform: translateY(-1px);
    color: rgba(255, 255, 255, 1) !important;
}

/* Boutons de connexion plus visibles */
.navbar .nav-link[href*="login"],
.navbar .nav-link[href*="register"] {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 8px 16px !important;
    margin: 0 4px;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.navbar .nav-link[href*="login"]:hover,
.navbar .nav-link[href*="register"]:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.4);
    transform: translateY(-2px);
}

/* Hero Section */
.hero-section {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    z-index: -1;
}

.hero-background::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.hero-content {
    animation: fadeInUp 1s ease-out;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 1.5rem;
}

.text-gradient {
    background: linear-gradient(45deg, #fff, #f0f8ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-subtitle {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.hero-stats {
    display: flex;
    gap: 2rem;
    margin-bottom: 2.5rem;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: white;
    display: block;
}

.stat-label {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.btn-primary-custom {
    background: linear-gradient(135deg, #fff, #f8f9fa);
    color: var(--primary-color);
    border: none;
    border-radius: 50px;
    padding: 15px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
}

.btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 255, 255, 0.4);
    color: var(--primary-dark);
}

.btn-outline-light {
    border: 2px solid rgba(255, 255, 255, 0.5);
    border-radius: 50px;
    padding: 13px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-light:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: white;
    transform: translateY(-2px);
}

/* Floating Cards */
.hero-image {
    position: relative;
    height: 500px;
}

.floating-card {
    position: absolute;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    animation: float 6s ease-in-out infinite;
}

.floating-card:first-child {
    top: 20%;
    right: 10%;
    width: 250px;
}

.floating-card-2 {
    top: 60%;
    left: 10%;
    width: 250px;
    animation-delay: -3s;
}

.card-content i {
    font-size: 2rem;
}

.card-content h5 {
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

/* Scroll Indicator */
.scroll-indicator {
    position: absolute;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
}

.scroll-down {
    color: white;
    font-size: 1.5rem;
    animation: bounce 2s infinite;
    text-decoration: none;
}

/* Sections */
.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.section-subtitle {
    font-size: 1.1rem;
    color: #6b7280;
    margin-bottom: 3rem;
}

/* Features Section */
.features-section {
    background: #f8fafc;
}

.feature-card {
    background: white;
    padding: 2.5rem 2rem;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    height: 100%;
}

.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.feature-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 1.8rem;
}

.feature-card h4 {
    color: var(--primary-color);
    margin-bottom: 1rem;
    font-weight: 600;
}

/* Vehicle Cards */
.vehicle-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.vehicle-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.vehicle-image {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.vehicle-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.vehicle-card:hover .vehicle-image img {
    transform: scale(1.05);
}

.no-image {
    width: 100%;
    height: 100%;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 3rem;
}

.vehicle-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.vehicle-card:hover .vehicle-overlay {
    opacity: 1;
}

.vehicle-content {
    padding: 1.5rem;
}

.price {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-color);
}

/* About Section */
.about-section {
    background: white;
}

.about-features {
    margin-top: 2rem;
}

.about-feature {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.about-image {
    text-align: center;
}

.image-placeholder {
    background: #f8fafc;
    border-radius: 20px;
    padding: 3rem;
    border: 2px dashed #e2e8f0;
}

/* CTA Section */
.cta-section {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    padding: 5rem 0;
}

.cta-actions {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 1rem;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-10px); }
    60% { transform: translateY(-5px); }
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-stats {
        flex-direction: column;
        gap: 1rem;
    }
    
    .hero-actions {
        justify-content: center;
    }
    
    .floating-card {
        display: none;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .cta-actions {
        flex-direction: column;
        align-items: center;
    }
}
</style>
@endsection
