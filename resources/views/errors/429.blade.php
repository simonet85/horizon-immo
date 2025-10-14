@extends('errors.layout')

@section('title', 'Trop de requêtes')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-50 to-indigo-100">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-2xl p-8 text-center">
            <!-- Icône d'erreur -->
            <div class="mb-6">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-purple-100 rounded-full mb-4">
                    <svg class="w-12 h-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Code d'erreur -->
            <h1 class="text-6xl font-bold text-gray-900 mb-2">429</h1>
            
            <!-- Message d'erreur -->
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Trop de requêtes</h2>
            <p class="text-gray-600 mb-8 leading-relaxed">
                Vous avez effectué trop de requêtes en peu de temps. 
                Veuillez patienter quelques minutes avant de réessayer.
            </p>

            <!-- Compteur de temps (optionnel) -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600 mb-2">Veuillez attendre :</p>
                <div class="text-2xl font-mono font-bold text-purple-600" id="countdown">60</div>
                <p class="text-xs text-gray-500">secondes</p>
            </div>

            <!-- Boutons d'action -->
            <div class="space-y-4">
                <a href="javascript:history.back()" class="btn-outline block w-full" id="backButton" style="display: none;">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour
                </a>
                
                <a href="{{ url('/') }}" class="btn-primary block w-full">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Retour à l'accueil
                </a>
            </div>

            <!-- Informations supplémentaires -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500">
                    Cette limitation protège notre serveur contre les abus.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    // Compteur de temps
    let timeLeft = 60;
    const countdownElement = document.getElementById('countdown');
    const backButton = document.getElementById('backButton');
    
    const timer = setInterval(() => {
        timeLeft--;
        countdownElement.textContent = timeLeft;
        
        if (timeLeft <= 0) {
            clearInterval(timer);
            countdownElement.textContent = '0';
            backButton.style.display = 'block';
            backButton.innerHTML = `
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Réessayer maintenant
            `;
        }
    }, 1000);
</script>

<style>
    .btn-primary {
        @apply bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl;
    }
    
    .btn-outline {
        @apply border-2 border-yellow-500 text-yellow-500 hover:bg-yellow-500 hover:text-white font-medium py-3 px-6 rounded-lg transition-all duration-200;
    }
</style>
@endsection
