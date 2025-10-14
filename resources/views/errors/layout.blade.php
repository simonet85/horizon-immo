<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? 'Erreur' }} - ZB Investments</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/images/logo-zb.png">
    <link rel="shortcut icon" type="image/png" href="/images/logo-zb.png">
    <link rel="apple-touch-icon" href="/images/logo-zb.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional CSS -->
    <style>
        .btn-primary {
            @apply bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl;
        }
        
        .btn-secondary {
            @apply bg-blue-900 hover:bg-blue-800 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl;
        }
        
        .btn-outline {
            @apply border-2 border-yellow-500 text-yellow-500 hover:bg-yellow-500 hover:text-white font-medium py-3 px-6 rounded-lg transition-all duration-200;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation simplifiée pour les pages d'erreur -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        <img src="/images/logo-zb.png" alt="ZB Investments" class="h-12 w-auto mr-3">
                        <span class="font-bold text-xl text-blue-900">ZB Investments</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenu de la page d'erreur -->
    <main>
        @yield('content')
    </main>

    <!-- Footer simplifié -->
    <footer class="bg-blue-900 text-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} ZB Investments. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>
