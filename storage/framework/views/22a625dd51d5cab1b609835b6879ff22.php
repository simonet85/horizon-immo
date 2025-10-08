<form wire:submit.prevent="updateAvatar">
    <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200">
        <!-- En-tête avec avatar actuel -->
        <div class="flex items-start space-x-6 mb-6">
            <div class="flex-shrink-0">
                <?php if($currentAvatar): ?>
                    <img src="<?php echo e(Storage::url($currentAvatar)); ?>" 
                         alt="Avatar actuel" 
                         class="w-20 h-20 rounded-full object-cover border-4 border-gray-200 shadow-md">
                <?php else: ?>
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white text-2xl font-bold shadow-md">
                        <?php
                            $name = trim(Auth::user()->name);
                            if (empty($name)) {
                                $initials = 'U';
                            } else {
                                // Séparer par espaces et tirets
                                $nameParts = preg_split('/[\s\-]+/', $name);
                                $initials = '';
                                foreach ($nameParts as $part) {
                                    $part = trim($part);
                                    if (!empty($part)) {
                                        $initials .= strtoupper(substr($part, 0, 1));
                                    }
                                }
                                if (empty($initials)) {
                                    $initials = 'U';
                                }
                            }
                            echo $initials;
                        ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="flex-1">
                <h4 class="text-lg font-semibold text-gray-900 mb-2">
                    <?php if($avatar): ?>
                        Nouvelle photo sélectionnée
                    <?php else: ?>
                        Photo de profil
                    <?php endif; ?>
                </h4>
                <?php if($avatar): ?>
                    <p class="text-sm text-blue-600 font-medium mb-2">
                        ✨ Votre nouvelle photo est prête ! Cliquez sur "Mettre à jour" pour la sauvegarder.
                    </p>
                    <p class="text-xs text-gray-500">
                        Fichier : <?php echo e($avatar->getClientOriginalName()); ?> (<?php echo e(number_format($avatar->getSize() / 1024, 1)); ?> KB)
                    </p>
                <?php else: ?>
                    <p class="text-sm text-gray-600 mb-4">
                        Personnalisez votre profil avec une photo. Formats acceptés : JPG, PNG, GIF. Taille max : 2 MB.
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Zone d'upload unique -->
        <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 hover:border-blue-400 transition-colors duration-200 bg-gray-50 hover:bg-blue-50">
            <div class="text-center">
                <div class="mx-auto w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                </div>
                
                <div class="space-y-2">
                    <label for="avatar-upload" class="cursor-pointer">
                        <span class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <?php if($currentAvatar): ?>
                                Changer la photo
                            <?php else: ?>
                                Ajouter une photo
                            <?php endif; ?>
                        </span>
                        <input id="avatar-upload" type="file" class="sr-only" wire:model="avatar" accept="image/*">
                    </label>
                    
                    <p class="text-sm text-gray-500">
                        ou glissez-déposez votre fichier ici
                    </p>
                    
                    <?php if($currentAvatar && !$avatar): ?>
                        <div class="mt-4">
                            <button type="button" 
                                    wire:click="deleteAvatar" 
                                    wire:confirm="Êtes-vous sûr de vouloir supprimer votre photo de profil ?"
                                    class="text-red-600 hover:text-red-800 text-sm font-medium px-4 py-2 rounded-md hover:bg-red-50 transition-colors duration-200 flex items-center mx-auto">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Supprimer la photo
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div wire:loading wire:target="avatar" class="mt-4">
                    <div class="inline-flex items-center text-blue-600">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-sm font-medium">Chargement de votre photo...</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aperçu de la photo sélectionnée -->
        <?php if($avatar): ?>
            <div class="bg-green-50 border border-green-200 rounded-xl p-6 mt-6">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="relative">
                            <img src="<?php echo e($avatar->temporaryUrl()); ?>" 
                                 alt="Aperçu de la nouvelle photo" 
                                 class="w-24 h-24 rounded-full object-cover border-4 border-green-200 shadow-md">
                            <div class="absolute -top-1 -right-1 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-lg font-semibold text-green-800 mb-1">
                                    Aperçu de votre nouvelle photo
                                </h4>
                                <p class="text-sm text-green-700 mb-2">
                                    Cette photo remplacera votre avatar actuel une fois sauvegardée.
                                </p>
                                <div class="text-xs text-green-600 space-y-1">
                                    <p><strong>Fichier :</strong> <?php echo e($avatar->getClientOriginalName()); ?></p>
                                    <p><strong>Taille :</strong> <?php echo e(number_format($avatar->getSize() / 1024, 1)); ?> KB</p>
                                    <p><strong>Type :</strong> <?php echo e(strtoupper(pathinfo($avatar->getClientOriginalName(), PATHINFO_EXTENSION))); ?></p>
                                </div>
                            </div>
                            <button type="button" 
                                    wire:click="$set('avatar', null)"
                                    class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition-colors duration-200"
                                    title="Annuler la sélection">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Messages de validation -->
        <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mt-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            Erreur de validation
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <?php echo e($message); ?>

                        </div>
                    </div>
                </div>
            </div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <!-- Boutons d'action -->
        <?php if($avatar): ?>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-blue-800 text-sm font-medium">Photo prête à être sauvegardée</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button type="button" 
                                wire:click="$set('avatar', null)"
                                class="text-gray-600 hover:text-gray-800 text-sm font-medium px-3 py-1 rounded-md hover:bg-gray-100 transition-colors duration-200">
                            Annuler
                        </button>
                        <button type="submit" 
                                wire:loading.attr="disabled"
                                wire:target="updateAvatar"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium text-sm disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200 flex items-center">
                            <span wire:loading.remove wire:target="updateAvatar" class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Mettre à jour l'avatar
                            </span>
                            <span wire:loading wire:target="updateAvatar" class="flex items-center">
                                <svg class="animate-spin w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 818-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Mise à jour...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Conseils -->
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mt-6">
            <h5 class="text-sm font-medium text-gray-900 mb-2 flex items-center">
                <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Conseils pour une photo parfaite
            </h5>
            <ul class="text-sm text-gray-600 space-y-1">
                <li>• Utilisez une photo récente et claire de votre visage</li>
                <li>• Évitez les photos floues ou trop sombres</li>
                <li>• Formats recommandés : JPG ou PNG</li>
                <li>• Taille optimale : 400x400 pixels minimum</li>
            </ul>
        </div>
    </div>
</form><?php /**PATH C:\laragon\www\HorizonImmo\resources\views\livewire\profile\update-avatar-form.blade.php ENDPATH**/ ?>