@extends('errors.layout')

@section('title', 'Erreur serveur')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-red-50 to-pink-100">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-2xl p-8 text-center">
            <!-- Icône d'erreur -->
            <div class="mb-6">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-red-100 rounded-full mb-4">
                    <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Code d'erreur -->
            <h1 class="text-6xl font-bold text-gray-900 mb-2">500</h1>
            
            <!-- Message d'erreur -->
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Erreur serveur</h2>
            <p class="text-gray-600 mb-8 leading-relaxed">
                Une erreur interne du serveur s'est produite. Notre équipe technique a été 
                automatiquement notifiée et travaille à résoudre le problème.
            </p>

            <!-- Boutons d'action -->
            <div class="space-y-4">
                <a href="{{ url('/') }}" class="btn-primary block w-full">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Retour à l'accueil
                </a>
                
                <a href="javascript:location.reload()" class="btn-outline block w-full">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Réessayer
                </a>
            </div>

            <!-- Informations supplémentaires -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500">
                    Si le problème persiste, 
                    <a href="{{ url('/contact') }}" class="text-blue-600 hover:text-blue-800 font-medium">contactez notre support</a>.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-primary {
        @apply bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl;
    }
    
    .btn-outline {
        @apply border-2 border-yellow-500 text-yellow-500 hover:bg-yellow-500 hover:text-white font-medium py-3 px-6 rounded-lg transition-all duration-200;
    }
</style>
@endsection
