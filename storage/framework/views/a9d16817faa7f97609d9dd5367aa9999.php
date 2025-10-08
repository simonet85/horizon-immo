<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

?>

<div class="animate-fade-in">
    <!-- Header with elegant typography -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-orange-500 to-amber-500 rounded-2xl mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V11a2 2 0 012-2m0 0V9a2 2 0 012-2h6a2 2 0 012 2v2m-6 6h.01"/>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2 tracking-tight">Mot de passe oublié ?</h1>
        <p class="text-gray-600 text-lg leading-relaxed max-w-md mx-auto">
            Pas d'inquiétude ! Saisissez votre email et recevez un lien sécurisé pour créer un nouveau mot de passe.
        </p>
    </div>

    <!-- Session Status -->
    <?php if(session('status')): ?>
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl animate-fade-in">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="ml-3 text-sm font-medium"><?php echo e(session('status')); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Instructions Card -->
    <div class="mb-8 p-4 bg-orange-50 border border-orange-200 rounded-xl">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-orange-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-semibold text-orange-800 mb-1">Comment ça marche</h3>
                <div class="text-sm text-orange-700 space-y-1">
                    <p>1. Saisissez l'email de votre compte</p>
                    <p>2. Vérifiez votre boîte mail (et les spams)</p>
                    <p>3. Cliquez sur le lien reçu</p>
                    <p>4. Créez votre nouveau mot de passe</p>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit="sendPasswordResetLink" class="space-y-6">
        <!-- Email Field -->
        <div class="group">
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                Adresse email
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-orange-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                    </svg>
                </div>
                <input 
                    wire:model="email" 
                    id="email" 
                    type="email" 
                    name="email"
                    class="block w-full pl-12 pr-4 py-4 border <?php echo e($errors->get('email') ? 'border-red-300 bg-red-50' : 'border-gray-300 bg-white'); ?> rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200" 
                    placeholder="votre.email@exemple.com"
                    required 
                    autofocus 
                />
            </div>
            <?php if($errors->get('email')): ?>
                <div class="mt-2 flex items-center text-sm text-red-600">
                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <?php echo e($errors->get('email')[0]); ?>

                </div>
            <?php endif; ?>
        </div>

        <!-- Send Link Button -->
        <div class="space-y-4">
            <button type="submit" 
                    class="w-full flex justify-center items-center py-4 px-6 border border-transparent rounded-xl text-base font-semibold text-white bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                    wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="sendPasswordResetLink" class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Envoyer le lien de réinitialisation
                </span>
                <span wire:loading wire:target="sendPasswordResetLink" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Envoi en cours...
                </span>
            </button>
        </div>

        <!-- Security Notice -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5-2a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-semibold text-blue-800 mb-1">Sécurité garantie</h3>
                    <p class="text-sm text-blue-700">
                        Le lien est valide 1 heure et ne peut être utilisé qu'une seule fois pour votre sécurité.
                    </p>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="relative my-8">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-gray-500 font-medium">Vous vous souvenez ?</span>
            </div>
        </div>

        <!-- Back to Login -->
        <div>
            <a href="<?php echo e(route('login')); ?>" wire:navigate 
               class="w-full flex justify-center items-center py-4 px-6 border-2 border-gray-300 rounded-xl text-base font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 transform hover:scale-[1.02]">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 713-3h7a3 3 0 013 3v1"/>
                </svg>
                Retour à la connexion
            </a>
        </div>

        <!-- Back to Home -->
        <div class="text-center pt-4">
            <a href="/" wire:navigate class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour à l'accueil
            </a>
        </div>
    </form>
</div><?php /**PATH C:\laragon\www\HorizonImmo\resources\views\livewire\pages\auth\forgot-password.blade.php ENDPATH**/ ?>