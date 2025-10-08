<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <title><?php echo e($title ?? 'Immobilier SA - Votre Rêve Immobilier en Afrique du Sud'); ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <!-- Additional CSS -->
    <style>
        .bg-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                        url('https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
        }
        
        .btn-primary {
            @apply bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200;
        }
        
        .btn-secondary {
            @apply bg-blue-900 hover:bg-blue-800 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200;
        }
        
        .btn-outline {
            @apply border-2 border-yellow-500 text-yellow-500 hover:bg-yellow-500 hover:text-white font-medium py-3 px-6 rounded-lg transition-all duration-200;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        <div class="bg-blue-900 text-white p-2 rounded-lg mr-3">
                            <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                        </div>
                        <span class="font-bold text-xl text-blue-900">Immobilier SA</span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-700 hover:text-blue-900 font-medium">Accueil</a>
                    <a href="/nos-ventes" class="text-gray-700 hover:text-blue-900 font-medium">Nos Ventes</a>
                    <a href="/catalogue" class="text-gray-700 hover:text-blue-900 font-medium">Catalogue</a>
                    <a href="/contact" class="text-gray-700 hover:text-blue-900 font-medium">Contact</a>
                    <a href="/accompagnement" class="btn-primary">Consultation Gratuite</a>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button x-data x-on:click="$dispatch('toggle-mobile-menu')" class="text-gray-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div x-data="{ open: false }" x-on:toggle-mobile-menu.window="open = !open" x-show="open" x-transition class="md:hidden bg-white border-t">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/" class="block px-3 py-2 text-gray-700 hover:text-blue-900">Accueil</a>
                <a href="/nos-ventes" class="block px-3 py-2 text-gray-700 hover:text-blue-900">Nos Ventes</a>
                <a href="/catalogue" class="block px-3 py-2 text-gray-700 hover:text-blue-900">Catalogue</a>
                <a href="/contact" class="block px-3 py-2 text-gray-700 hover:text-blue-900">Contact</a>
                <a href="/accompagnement" class="block px-3 py-2 bg-green-600 text-white rounded-lg m-3">Consultation Gratuite</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?php echo e($slot); ?>

    </main>

    <!-- Footer -->
    <footer class="bg-blue-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center mb-4">
                        <div class="bg-white text-blue-900 p-2 rounded-lg mr-3">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                        </div>
                        <span class="font-bold text-xl">Immobilier SA</span>
                    </div>
                    <p class="text-gray-300 text-sm">
                        Votre partenaire de confiance pour investir dans l'immobilier sud-africain. Expertise, accompagnement personnalisé et financement sécurisé.
                    </p>
                    <div class="flex items-center mt-4 space-x-4">
                        <span class="bg-green-600 text-white px-2 py-1 rounded text-sm">Certifié & Assuré</span>
                        <span class="bg-yellow-600 text-white px-2 py-1 rounded text-sm">Expert Agréé</span>
                    </div>
                </div>

                <!-- Services -->
                <div>
                    <h3 class="font-semibold text-lg mb-4">Nos Services</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li>Courtage Immobilier</li>
                        <li>Accompagnement Financier</li>
                        <li>Conseils Personnalisés</li>
                        <li>Visites Guidées</li>
                        <li>Support Juridique</li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="font-semibold text-lg mb-4">Contact</h3>
                    <div class="space-y-2 text-gray-300">
                        <div class="flex items-center">
                            <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            <span>contact@immobilier-sa.com</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                            <div>
                                <div>+33 1 XX XX XX XX</div>
                                <div>+27 XXX XXX XXXX (Afrique du Sud)</div>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="h-4 w-4 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <div>Bureau France & Afrique du Sud</div>
                                <div class="text-sm">Sur rendez-vous uniquement</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations -->
                <div>
                    <h3 class="font-semibold text-lg mb-4">Informations</h3>
                    <div class="space-y-2 text-gray-300">
                        <div class="flex items-center">
                            <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <div class="font-medium">Horaires</div>
                                <div class="text-sm">Lun - Ven: 9h - 18h</div>
                                <div class="text-sm">Sam: 9h - 13h</div>
                                <div class="text-sm">Dim: Sur rendez-vous</div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <div class="font-medium text-yellow-400 mb-2">Partenaire Officiel</div>
                            <div class="bg-white text-blue-900 px-3 py-1 rounded text-sm font-medium inline-block">
                                Standard Bank
                            </div>
                            <div class="text-xs text-gray-400 mt-1">Solutions de financement privilégiées</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-blue-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 Immobilier SA. Tous droits réservés.</p>
                <div class="mt-2 space-x-4 text-sm">
                    <a href="#" class="hover:text-white">Mentions Légales</a>
                    <a href="#" class="hover:text-white">Confidentialité</a>
                    <a href="#" class="hover:text-white">CGU</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
<?php /**PATH C:\laragon\www\HorizonImmo\resources\views\layouts\site.blade.php ENDPATH**/ ?>