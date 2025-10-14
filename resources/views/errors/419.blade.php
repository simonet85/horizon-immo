@extends('errors.layout')

@section('title', 'Session expirée')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-yellow-50 to-orange-100">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-2xl p-8 text-center">
            <!-- Icône d'erreur -->
            <div class="mb-6">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-yellow-100 rounded-full mb-4">
                    <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Code d'erreur -->
            <h1 class="text-6xl font-bold text-gray-900 mb-2">419</h1>
            
            <!-- Message d'erreur -->
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Session expirée</h2>
            <p class="text-gray-600 mb-8 leading-relaxed">
                Votre session a expiré pour des raisons de sécurité. 
                Veuillez actualiser la page et réessayer votre action.
            </p>

            <!-- Boutons d'action -->
            <div class="space-y-4">
                <a href="javascript:location.reload()" class="btn-primary block w-full">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Actualiser la page
                </a>
                
                <a href="{{ url('/login') }}" class="btn-outline block w-full">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Se reconnecter
                </a>
            </div>

            <!-- Informations supplémentaires -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500">
                    Cette erreur se produit généralement après une longue période d'inactivité.
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
