@extends('layouts.admin')

@section('title', 'Mon Profil')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <!-- En-tête du profil avec gradient -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-700 rounded-xl shadow-lg overflow-hidden">
        <div class="px-8 py-6 text-white">
            <div class="flex items-center">
                <div class="w-20 h-20 mr-6">
                    @if(Auth::user()->avatar)
                        <img class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-lg" 
                             src="{{ \Illuminate\Support\Facades\Storage::url(Auth::user()->avatar) }}" 
                             alt="Avatar de {{ Auth::user()->name }}">
                    @else
                        <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center text-white text-2xl font-bold border-4 border-white shadow-lg">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-bold mb-2">{{ Auth::user()->name }}</h1>
                    <div class="flex items-center space-x-4 text-blue-100">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                            {{ Auth::user()->email }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            {{ Auth::user()->getRoleNames()->first() ?? 'Utilisateur' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grille responsive pour les sections -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Colonne principale -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Photo de profil -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">Photo de profil</h3>
                            <p class="text-sm text-gray-600 mt-1">Personnalisez votre avatar pour une meilleure expérience.</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    @livewire('forms.update-avatar-form')
                </div>
            </div>

            <!-- Informations personnelles -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <!-- Mot de passe -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6">
                    <livewire:profile.update-password-form />
                </div>
            </div>
        </div>

        <!-- Barre latérale -->
        <div class="space-y-8">
            <!-- Statistiques du compte -->
            @if(Auth::user()->hasRole('admin'))
            <div class="bg-gradient-to-br from-blue-50 to-indigo-100 border border-blue-200 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 00-2-2z"></path>
                    </svg>
                    Informations administrateur
                </h3>
                <div class="space-y-4">
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                    </div>
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <div class="text-2xl font-bold text-green-600">Admin</div>
                        <div class="text-sm text-gray-600">Niveau d'accès</div>
                    </div>
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <div class="text-2xl font-bold text-purple-600">Complet</div>
                        <div class="text-sm text-gray-600">Permissions</div>
                    </div>
                </div>
            </div>
            @endif

            @if(Auth::user()->hasRole('client'))
            <div class="bg-gradient-to-br from-green-50 to-emerald-100 border border-green-200 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-green-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Mon espace client
                </h3>
                <div class="space-y-4">
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <div class="text-2xl font-bold text-green-600">{{ Auth::user()->created_at->diffForHumans() }}</div>
                        <div class="text-sm text-gray-600">Client depuis</div>
                    </div>
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-2xl font-bold text-blue-600">Client</div>
                                <div class="text-sm text-gray-600">Statut</div>
                            </div>
                            <a href="{{ route('client.dashboard') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Voir mon espace →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Actions rapides -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Actions rapides
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center justify-between bg-white p-3 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v10M16 7v10"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">Tableau de bord</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    @if(Auth::user()->hasRole('admin'))
                    <a href="{{ route('admin.users.index') }}" class="flex items-center justify-between bg-white p-3 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">Gestion utilisateurs</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Section suppression de compte - en bas et séparée -->
    <div class="mt-12">
        <div class="bg-white rounded-xl shadow-sm border border-red-200 overflow-hidden">
            <div class="p-6">
                <livewire:profile.delete-user-form />
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Messages de succès pour les formulaires Livewire
document.addEventListener('livewire:init', function () {
    Livewire.on('profile-updated', (event) => {
        // Notification toast pour le profil mis à jour
        console.log('Profil mis à jour avec succès');
    });
    
    Livewire.on('password-updated', (event) => {
        // Notification toast pour le mot de passe mis à jour
        console.log('Mot de passe mis à jour avec succès');
    });
    
    Livewire.on('avatar-updated', (event) => {
        // Notification toast pour l'avatar mis à jour
        console.log('Avatar mis à jour avec succès');
        // Recharger la page pour mettre à jour l'avatar dans l'en-tête
        setTimeout(() => {
            window.location.reload();
        }, 1000);
    });
    
    Livewire.on('avatar-deleted', (event) => {
        // Notification toast pour l'avatar supprimé
        console.log('Avatar supprimé avec succès');
        // Recharger la page pour mettre à jour l'en-tête
        setTimeout(() => {
            window.location.reload();
        }, 1000);
    });
});
</script>
@endpush
@endsection
