@extends('errors.layout')

@section('title', 'Page non trouvée')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-2xl p-8 text-center">
            <!-- Icône d'erreur -->
            <div class="mb-6">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-red-100 rounded-full mb-4">
                    <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
            </div>

            <!-- Code d'erreur -->
            <h1 class="text-6xl font-bold text-gray-900 mb-2">404</h1>
            
            <!-- Message d'erreur -->
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Page non trouvée</h2>
            <p class="text-gray-600 mb-8 leading-relaxed">
                Désolé, la page que vous recherchez n'existe pas ou a été déplacée. 
                Vérifiez l'URL ou retournez à la page d'accueil.
            </p>

            <!-- Boutons d'action -->
            <div class="space-y-4">
                <a href="{{ url('/') }}" class="btn-primary block w-full">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Retour à l'accueil
                </a>
                
                <a href="javascript:history.back()" class="btn-outline block w-full">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Page précédente
                </a>
            </div>

            <!-- Informations supplémentaires -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500">
                    Si vous pensez qu'il s'agit d'une erreur, 
                    <a href="{{ url('/contact') }}" class="text-blue-600 hover:text-blue-800 font-medium">contactez-nous</a>.
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
