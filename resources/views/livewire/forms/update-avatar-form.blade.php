<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Photo de profil</h2>
    
    <!-- Affichage de l'avatar actuel ou des initiales -->
    <div class="flex items-center space-x-6 mb-6">
        <div class="shrink-0">
            @if(Auth::user()->avatar)
                <img class="h-20 w-20 rounded-full object-cover" 
                     src="{{ Storage::url(Auth::user()->avatar) }}" 
                     alt="Avatar actuel">
            @else
                <div class="h-20 w-20 bg-blue-500 rounded-full flex items-center justify-center text-white text-xl font-bold">
                    {{ $this->getUserInitials() }}
                </div>
            @endif
        </div>
        
        <div>
            <p class="text-sm text-gray-600">
                {{ Auth::user()->avatar ? 'Votre photo de profil actuelle' : 'Vous n\'avez pas encore de photo de profil' }}
            </p>
            @if(Auth::user()->avatar)
                <button type="button" 
                        wire:click="deleteAvatar"
                        wire:confirm="Êtes-vous sûr de vouloir supprimer votre avatar ?"
                        class="mt-2 text-sm text-red-600 hover:text-red-700">
                    Supprimer la photo
                </button>
            @endif
        </div>
    </div>

    <!-- Prévisualisation si un fichier est sélectionné -->
    @if($temporaryUrl)
        <div class="mb-6 bg-gradient-to-r from-green-50 to-blue-50 border border-green-200 rounded-lg p-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Prévisualisation de votre nouvelle photo
            </h3>
            <div class="flex items-center space-x-6">
                <img class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-lg" 
                     src="{{ $temporaryUrl }}" 
                     alt="Prévisualisation">
                <div class="flex-1">
                    <p class="text-sm text-gray-700 mb-4">
                        Votre nouvelle photo de profil est prête ! Cliquez sur "Enregistrer" pour la confirmer ou choisissez un autre fichier pour la remplacer.
                    </p>
                    <div class="flex space-x-3">
                        <button type="button" 
                                wire:click="updateAvatar"
                                wire:loading.attr="disabled"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-blue-600 text-white font-semibold rounded-lg shadow-md hover:from-green-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 disabled:opacity-50">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span wire:loading.remove wire:target="updateAvatar">Enregistrer cette photo</span>
                            <span wire:loading wire:target="updateAvatar">Enregistrement...</span>
                        </button>
                        <button type="button" 
                                wire:click="cancelSelection"
                                class="inline-flex items-center px-4 py-3 bg-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-400 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Upload de fichier -->
    <div class="mb-4">
        <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">
            Choisir une nouvelle photo
        </label>
        <input type="file" 
               id="avatar"
               wire:model="avatar"
               accept="image/*"
               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        
        @error('avatar')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        
        <p class="mt-1 text-sm text-gray-500">
            PNG, JPG, GIF jusqu'à 2MB
        </p>
    </div>

    <!-- Indicateur de chargement -->
    <div wire:loading wire:target="avatar" class="text-sm text-blue-600">
        Traitement de l'image...
    </div>
    
    <div wire:loading wire:target="updateAvatar" class="text-sm text-blue-600">
        Enregistrement en cours...
    </div>

    <!-- Messages de succès et d'information -->
    @if (session('success'))
        <div class="mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session('info'))
        <div class="mt-4 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-md flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('info') }}
        </div>
    @endif
</div>

<script>
    // Rafraîchir l'interface quand l'avatar est mis à jour
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('avatar-updated', () => {
            // Recharger les éléments qui affichent l'avatar
            window.location.reload();
        });
    });
</script>
