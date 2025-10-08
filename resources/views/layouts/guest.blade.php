<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? 'Connexion' }} - Immobilier SA</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional CSS -->
    <style>
        .bg-auth {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.9), rgba(59, 130, 246, 0.8)), 
                        url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
        }
        
        .btn-primary {
            @apply bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl;
        }
        
        .btn-secondary {
            @apply bg-blue-900 hover:bg-blue-800 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl;
        }
        
        .btn-outline {
            @apply border-2 border-yellow-500 text-yellow-500 hover:bg-yellow-500 hover:text-white font-medium py-3 px-6 rounded-lg transition-all duration-200;
        }
        
        .glass-card {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Inputs et formulaires */
        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            @apply block text-sm font-semibold text-gray-700 mb-2 transition-all duration-200;
        }
        
        .form-label.required::after {
            content: ' *';
            color: #ef4444;
        }
        
        .input-field {
            @apply w-full px-4 py-3 border border-gray-300 rounded-xl bg-white text-gray-900 placeholder-gray-400 transition-all duration-300 ease-in-out;
            font-size: 16px; /* Évite le zoom sur mobile */
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .input-field:focus {
            @apply outline-none border-blue-500 ring-4 ring-blue-500/20;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }
        
        .input-field:hover:not(:focus) {
            @apply border-gray-400;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .input-field.error {
            @apply border-red-400 bg-red-50;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }
        
        .input-field.error:focus {
            @apply border-red-500 ring-red-500/20;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);
        }
        
        .input-field.success {
            @apply border-green-400 bg-green-50;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
        }
        
        .input-field.success:focus {
            @apply border-green-500 ring-green-500/20;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.15);
        }
        
        /* Labels flottants */
        .floating-label {
            position: relative;
        }
        
        .floating-label input {
            @apply pt-6 pb-2;
        }
        
        .floating-label label {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            padding: 0 4px;
            color: #6b7280;
            pointer-events: none;
            transition: all 0.3s ease;
            font-size: 16px;
        }
        
        .floating-label input:focus + label,
        .floating-label input:not(:placeholder-shown) + label {
            top: 8px;
            font-size: 12px;
            color: #3b82f6;
            font-weight: 600;
        }
        
        .floating-label input.error + label {
            color: #ef4444;
        }
        
        .floating-label input.success + label {
            color: #22c55e;
        }
        
        /* Messages d'erreur et de succès */
        .error-message {
            @apply mt-2 text-sm text-red-600 flex items-start;
            animation: slideDown 0.3s ease-out;
        }
        
        .success-message {
            @apply mt-2 text-sm text-green-600 flex items-center;
            animation: slideDown 0.3s ease-out;
        }
        
        .help-text {
            @apply mt-1 text-xs text-gray-500;
        }
        
        /* Icônes dans les inputs */
        .input-with-icon {
            position: relative;
        }
        
        .input-with-icon .input-field {
            @apply pl-12;
        }
        
        .input-with-icon .icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            transition: color 0.3s ease;
        }
        
        .input-with-icon .input-field:focus ~ .icon {
            color: #3b82f6;
        }
        
        .input-with-icon .input-field.error ~ .icon {
            color: #ef4444;
        }
        
        .input-with-icon .input-field.success ~ .icon {
            color: #22c55e;
        }
        
        /* Boutons de formulaire */
        .btn-form {
            @apply w-full font-semibold py-4 px-6 rounded-xl transition-all duration-300 ease-in-out transform;
            font-size: 16px;
            min-height: 56px;
        }
        
        .btn-form:hover {
            transform: translateY(-2px);
        }
        
        .btn-form:active {
            transform: translateY(0);
        }
        
        .btn-form:disabled {
            @apply opacity-50 cursor-not-allowed;
            transform: none !important;
        }
        
        /* Checkbox et radio personnalisés */
        .custom-checkbox {
            @apply relative;
        }
        
        .custom-checkbox input[type="checkbox"] {
            @apply sr-only;
        }
        
        .custom-checkbox-indicator {
            @apply w-5 h-5 border-2 border-gray-300 rounded flex items-center justify-center transition-all duration-200;
            background: white;
        }
        
        .custom-checkbox input[type="checkbox"]:checked + .custom-checkbox-indicator {
            @apply bg-green-600 border-green-600;
        }
        
        .custom-checkbox input[type="checkbox"]:focus + .custom-checkbox-indicator {
            @apply ring-2 ring-green-500/20;
        }
        
        .custom-checkbox-indicator svg {
            @apply w-3 h-3 text-white opacity-0 transition-opacity duration-200;
        }
        
        .custom-checkbox input[type="checkbox"]:checked + .custom-checkbox-indicator svg {
            @apply opacity-100;
        }
        
        /* Animations */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        /* Responsive */
        @media (max-width: 640px) {
            .input-field {
                @apply px-3 py-3;
                font-size: 16px; /* Évite le zoom sur iOS */
            }
            
            .floating-label input {
                @apply pt-5 pb-2;
            }
            
            .floating-label label {
                font-size: 15px;
            }
            
            .floating-label input:focus + label,
            .floating-label input:not(:placeholder-shown) + label {
                font-size: 11px;
                top: 6px;
            }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-auth flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo and Header -->
            <div class="text-center">
                <div class="flex justify-center mb-6">
                    <a href="/" wire:navigate class="flex items-center group">
                        <div class="bg-white text-blue-900 p-3 rounded-xl mr-3 shadow-lg group-hover:shadow-xl transition-all duration-200">
                            <svg class="h-10 w-10" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                        </div>
                        <span class="font-bold text-2xl text-white">Immobilier SA</span>
                    </a>
                </div>
                <p class="text-white/80 text-sm">
                    Votre partenaire de confiance pour l'immobilier sud-africain
                </p>
            </div>

            <!-- Auth Form Card -->
            <div class="glass-card rounded-2xl shadow-2xl p-8">
                {{ $slot }}
            </div>
            
            <!-- Footer -->
            <div class="text-center">
                <p class="text-white/60 text-sm">
                    &copy; {{ date('Y') }} Immobilier SA. Tous droits réservés.
                </p>
                <div class="mt-2 space-x-4 text-sm">
                    <a href="#" class="text-white/80 hover:text-white transition-colors">Mentions Légales</a>
                    <a href="#" class="text-white/80 hover:text-white transition-colors">Confidentialité</a>
                    <a href="/contact" class="text-white/80 hover:text-white transition-colors">Contact</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
