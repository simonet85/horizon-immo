@extends('errors.layout')

@section('title', 'Accès refusé')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-orange-50 to-red-100">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-2xl p-8 text-center">
            <!-- Icône d'erreur -->
            <div class="mb-6">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-orange-100 rounded-full mb-4">
                    <svg class="w-12 h-12 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"/>
                    </svg>
                </div>
            </div>

            <!-- Code d'erreur -->
            <h1 class="text-6xl font-bold text-gray-900 mb-2">403</h1>
            
            <!-- Message d'erreur -->
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Accès refusé</h2>
            <p class="text-gray-600 mb-8 leading-relaxed">
                Vous n'avez pas l'autorisation d'accéder à cette ressource. 
                Veuillez vous connecter ou contacter un administrateur.
            </p>

            <!-- Boutons d'action -->
            <div class="space-y-4">
                <a href="{{ url('/login') }}" class="btn-primary block w-full">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Se connecter
                </a>
                
                <a href="{{ url('/') }}" class="btn-outline block w-full">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Retour à l'accueil
                </a>
            </div>

            <!-- Informations supplémentaires -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500">
                    Besoin d'aide ? 
                    <a href="{{ url('/contact') }}" class="text-blue-600 hover:text-blue-800 font-medium">Contactez-nous</a>.
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
