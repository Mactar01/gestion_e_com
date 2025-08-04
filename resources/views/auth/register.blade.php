<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - E-Commerce Premium</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            display: flex;
            min-height: 600px;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-image {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .register-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="rgba(255,255,255,0.1)"><polygon points="0,100 1000,0 1000,100"/></svg>');
            background-size: cover;
        }

        .image-content {
            text-align: center;
            color: white;
            position: relative;
            z-index: 2;
            padding: 40px;
        }

        .image-content h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            animation: fadeInUp 1s ease-out 0.3s both;
        }

        .image-content p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease-out 0.5s both;
        }

        .benefits-list {
            list-style: none;
            animation: fadeInUp 1s ease-out 0.7s both;
        }

        .benefits-list li {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .benefits-list i {
            width: 20px;
            color: #fff;
        }

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

        .register-form {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: #6c757d;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #2c3e50;
            font-size: 0.9rem;
        }

        .input-group {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fff;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 1.1rem;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .role-selector {
            margin-bottom: 1.5rem;
        }

        .role-options {
            display: flex;
            gap: 20px;
            margin-top: 0.5rem;
        }

        .role-option {
            flex: 1;
            position: relative;
        }

        .role-option input[type="radio"] {
            display: none;
        }

        .role-option label {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #fff;
        }

        .role-option input[type="radio"]:checked + label {
            border-color: #667eea;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .role-option i {
            font-size: 1.5rem;
            margin-bottom: 8px;
        }

        .register-button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .register-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .register-button:active {
            transform: translateY(0);
        }

        .login-link {
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid #e9ecef;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #764ba2;
        }

        .session-status {
            background: #d4edda;
            color: #155724;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border: 1px solid #c3e6cb;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .session-status.error {
            background: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.85rem;
        }

        .strength-bar {
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            margin-top: 0.25rem;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak { background: #dc3545; width: 25%; }
        .strength-medium { background: #ffc107; width: 50%; }
        .strength-strong { background: #28a745; width: 75%; }
        .strength-very-strong { background: #20c997; width: 100%; }

        /* Responsive */
        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
                max-width: 400px;
            }

            .register-image {
                display: none;
            }

            .register-form {
                padding: 30px 20px;
            }

            .form-header h1 {
                font-size: 1.5rem;
            }

            .role-options {
                flex-direction: column;
                gap: 10px;
            }
        }

        /* Loading animation */
        .loading {
            display: none;
        }

        .loading.active {
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Image Section -->
        <div class="register-image">
            <div class="image-content">
                <h2>Rejoignez-nous</h2>
                <p>Créez votre compte et accédez à notre catalogue premium</p>
                <ul class="benefits-list">
                    <li><i class="fas fa-star"></i> Accès exclusif aux offres</li>
                    <li><i class="fas fa-shipping-fast"></i> Livraison gratuite</li>
                    <li><i class="fas fa-headset"></i> Support prioritaire</li>
                    <li><i class="fas fa-gift"></i> Avantages fidélité</li>
                </ul>
            </div>
        </div>

        <!-- Form Section -->
        <div class="register-form">
            <div class="form-header">
                <h1>Inscription</h1>
                <p>Créez votre compte en quelques étapes</p>
            </div>

            @if ($errors->any())
                <div class="session-status error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label">Nom complet</label>
                    <div class="input-group">
                        <i class="fas fa-user input-icon"></i>
                        <input 
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}" 
                            class="form-input" 
                            placeholder="Votre nom complet"
                            required 
                            autofocus 
                            autocomplete="name"
                        >
                    </div>
                    @error('name')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Adresse email</label>
                    <div class="input-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            class="form-input" 
                            placeholder="votre@email.com"
                            required 
                            autocomplete="username"
                        >
                    </div>
                    @error('email')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Mot de passe</label>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="Votre mot de passe"
                            required 
                            autocomplete="new-password"
                            onkeyup="checkPasswordStrength(this.value)"
                        >
                    </div>
                    <div class="password-strength">
                        <span id="strength-text">Force du mot de passe</span>
                        <div class="strength-bar">
                            <div class="strength-fill" id="strength-fill"></div>
                        </div>
                    </div>
                    @error('password')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            class="form-input" 
                            placeholder="Confirmez votre mot de passe"
                            required 
                            autocomplete="new-password"
                        >
                    </div>
                    @error('password_confirmation')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Role Selector -->
                <div class="role-selector">
                    <label class="form-label">S'inscrire en tant que :</label>
                    <div class="role-options">
                        <div class="role-option">
                            <input type="radio" id="role_client" name="role" value="client" checked>
                            <label for="role_client">
                                <i class="fas fa-user"></i>
                                <span>Client</span>
                            </label>
                        </div>
                        <div class="role-option">
                            <input type="radio" id="role_admin" name="role" value="admin">
                            <label for="role_admin">
                                <i class="fas fa-user-shield"></i>
                                <span>Admin</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="register-button" id="registerBtn">
                    <i class="fas fa-user-plus"></i>
                    <span>Créer mon compte</span>
                    <i class="fas fa-spinner loading" id="loadingSpinner"></i>
                </button>
            </form>

            <!-- Login Link -->
            <div class="login-link">
                <p>
                    Déjà un compte ? 
                    <a href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt"></i>
                        Se connecter
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Form submission with loading animation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const button = document.getElementById('registerBtn');
            const spinner = document.getElementById('loadingSpinner');
            const buttonText = button.querySelector('span');
            
            // Show loading state
            button.disabled = true;
            spinner.classList.add('active');
            buttonText.textContent = 'Création...';
        });

        // Password strength checker
        function checkPasswordStrength(password) {
            const strengthText = document.getElementById('strength-text');
            const strengthFill = document.getElementById('strength-fill');
            
            let strength = 0;
            let feedback = '';

            // Check length
            if (password.length >= 8) strength += 1;
            if (password.length >= 12) strength += 1;
            
            // Check for different character types
            if (/[a-z]/.test(password)) strength += 1;
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[0-9]/.test(password)) strength += 1;
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;

            // Determine strength level
            if (strength <= 2) {
                feedback = 'Faible';
                strengthFill.className = 'strength-fill strength-weak';
            } else if (strength <= 3) {
                feedback = 'Moyen';
                strengthFill.className = 'strength-fill strength-medium';
            } else if (strength <= 4) {
                feedback = 'Fort';
                strengthFill.className = 'strength-fill strength-strong';
            } else {
                feedback = 'Très fort';
                strengthFill.className = 'strength-fill strength-very-strong';
            }

            strengthText.textContent = `Force du mot de passe: ${feedback}`;
        }

        // Add smooth animations on page load
        document.addEventListener('DOMContentLoaded', function() {
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach((group, index) => {
                group.style.animationDelay = `${0.1 * index}s`;
                group.style.animation = 'fadeInUp 0.6s ease-out both';
            });
        });
    </script>
</body>
</html>
