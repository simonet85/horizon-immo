<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

?>

<div class="animate-fade-in">
    <!-- Header with elegant typography -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-500 rounded-2xl mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.818-4.818A4 4 0 0121 12c0 2.21-1.79 4-4 4h-.5a2.5 2.5 0 01-2.5-2.5V12"/>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2 tracking-tight">Nouveau mot de passe</h1>
        <p class="text-gray-600 text-lg leading-relaxed max-w-md mx-auto">
            Parfait ! Créez maintenant un mot de passe sécurisé pour protéger votre compte.
        </p>
    </div>

    <!-- Security Tips Card -->
    <div class="mb-8 p-4 bg-green-50 border border-green-200 rounded-xl">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-green-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5-2a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-semibold text-green-800 mb-1">Conseils sécurité</h3>
                <div class="text-sm text-green-700 space-y-1">
                    <p>• Au moins 8 caractères</p>
                    <p>• Mélangez lettres, chiffres et symboles</p>
                    <p>• Évitez les informations personnelles</p>
                    <p>• Utilisez un mot de passe unique</p>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit="resetPassword" class="space-y-6">
        <!-- Email Field -->
        <div class="group">
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                Adresse email
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                    </svg>
                </div>
                <input 
                    wire:model="email" 
                    id="email" 
                    type="email" 
                    name="email"
                    class="block w-full pl-12 pr-4 py-4 border <?php echo e($errors->get('email') ? 'border-red-300 bg-red-50' : 'border-gray-300 bg-white'); ?> rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" 
                    placeholder="votre.email@exemple.com"
                    required 
                    autofocus 
                    autocomplete="username" 
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

        <!-- Password Field -->
        <div class="group">
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                Nouveau mot de passe
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input 
                    wire:model="password" 
                    id="password" 
                    type="password" 
                    name="password"
                    class="block w-full pl-12 pr-12 py-4 border <?php echo e($errors->get('password') ? 'border-red-300 bg-red-50' : 'border-gray-300 bg-white'); ?> rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" 
                    placeholder="••••••••••••"
                    required 
                    autocomplete="new-password" 
                    onkeyup="checkPasswordStrength(this.value)"
                />
                <button type="button" 
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                        onclick="togglePassword('password')"
                        aria-label="Afficher/masquer le mot de passe">
                    <svg class="w-5 h-5" id="password-show-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg class="w-5 h-5 hidden" id="password-hide-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                    </svg>
                </button>
            </div>
            <!-- Password Strength Indicator -->
            <div class="mt-3">
                <div class="flex space-x-1">
                    <div id="strength-bar-1" class="h-2 w-1/4 bg-gray-200 rounded-full transition-colors duration-300"></div>
                    <div id="strength-bar-2" class="h-2 w-1/4 bg-gray-200 rounded-full transition-colors duration-300"></div>
                    <div id="strength-bar-3" class="h-2 w-1/4 bg-gray-200 rounded-full transition-colors duration-300"></div>
                    <div id="strength-bar-4" class="h-2 w-1/4 bg-gray-200 rounded-full transition-colors duration-300"></div>
                </div>
                <p id="strength-text" class="text-xs text-gray-500 mt-1 font-medium">Minimum 8 caractères avec lettres et chiffres</p>
            </div>
            <?php if($errors->get('password')): ?>
                <div class="mt-2 flex items-center text-sm text-red-600">
                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <?php echo e($errors->get('password')[0]); ?>

                </div>
            <?php endif; ?>
        </div>

        <!-- Confirm Password Field -->
        <div class="group">
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                Confirmer le nouveau mot de passe
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <input 
                    wire:model="password_confirmation" 
                    id="password_confirmation" 
                    type="password" 
                    name="password_confirmation"
                    class="block w-full pl-12 pr-12 py-4 border <?php echo e($errors->get('password_confirmation') ? 'border-red-300 bg-red-50' : 'border-gray-300 bg-white'); ?> rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" 
                    placeholder="••••••••••••"
                    required 
                    autocomplete="new-password" 
                />
                <button type="button" 
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                        onclick="togglePassword('password_confirmation')"
                        aria-label="Afficher/masquer le mot de passe">
                    <svg class="w-5 h-5" id="password_confirmation-show-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg class="w-5 h-5 hidden" id="password_confirmation-hide-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                    </svg>
                </button>
            </div>
            <?php if($errors->get('password_confirmation')): ?>
                <div class="mt-2 flex items-center text-sm text-red-600">
                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <?php echo e($errors->get('password_confirmation')[0]); ?>

                </div>
            <?php endif; ?>
        </div>

        <!-- Reset Button -->
        <div class="space-y-4">
            <button type="submit" 
                    class="w-full flex justify-center items-center py-4 px-6 border border-transparent rounded-xl text-base font-semibold text-white bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                    wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="resetPassword" class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Réinitialiser le mot de passe
                </span>
                <span wire:loading wire:target="resetPassword" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Réinitialisation...
                </span>
            </button>
        </div>

        <!-- Success Notice -->
        <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-indigo-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-indigo-700">
                        <strong>Une fois validé,</strong> vous serez automatiquement connecté à votre compte avec votre nouveau mot de passe.
                    </p>
                </div>
            </div>
        </div>

        <!-- Back to Login -->
        <div class="text-center pt-4">
            <a href="<?php echo e(route('login')); ?>" wire:navigate class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour à la connexion
            </a>
        </div>
    </form>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const showIcon = document.getElementById(inputId + '-show-icon');
            const hideIcon = document.getElementById(inputId + '-hide-icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                showIcon.classList.add('hidden');
                hideIcon.classList.remove('hidden');
            } else {
                input.type = 'password';
                showIcon.classList.remove('hidden');
                hideIcon.classList.add('hidden');
            }
        }

        function checkPasswordStrength(password) {
            const bars = [
                document.getElementById('strength-bar-1'),
                document.getElementById('strength-bar-2'),
                document.getElementById('strength-bar-3'),
                document.getElementById('strength-bar-4')
            ];
            const strengthText = document.getElementById('strength-text');

            if (!bars[0] || !strengthText) return;

            // Reset all bars
            bars.forEach(bar => {
                bar.className = 'h-2 w-1/4 bg-gray-200 rounded-full transition-colors duration-300';
            });

            if (password.length === 0) {
                strengthText.textContent = 'Minimum 8 caractères avec lettres et chiffres';
                strengthText.className = 'text-xs text-gray-500 mt-1 font-medium';
                return;
            }

            let strength = 0;
            let feedback = [];

            // Length check
            if (password.length >= 8) {
                strength++;
            } else {
                feedback.push('8 caractères min');
            }

            // Lowercase check
            if (/[a-z]/.test(password)) {
                strength++;
            } else {
                feedback.push('minuscule');
            }

            // Uppercase or numbers check
            if (/[A-Z]/.test(password) || /[0-9]/.test(password)) {
                strength++;
            } else {
                feedback.push('majuscule/chiffre');
            }

            // Special characters check
            if (/[^A-Za-z0-9]/.test(password)) {
                strength++;
            }

            // Update bars
            const colors = ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-500'];
            const textColors = ['text-red-600', 'text-orange-600', 'text-yellow-600', 'text-green-600'];
            const messages = ['Très faible', 'Faible', 'Moyen', 'Fort'];

            for (let i = 0; i < strength; i++) {
                bars[i].className = `h-2 w-1/4 ${colors[strength - 1]} rounded-full transition-colors duration-300`;
            }

            if (strength > 0) {
                strengthText.textContent = messages[strength - 1];
                strengthText.className = `text-xs ${textColors[strength - 1]} mt-1 font-medium`;
            }

            if (feedback.length > 0 && password.length > 0) {
                strengthText.textContent += ' • Manque: ' + feedback.join(', ');
            }
        }
    </script>
</div><?php /**PATH C:\laragon\www\HorizonImmo\resources\views\livewire\pages\auth\reset-password.blade.php ENDPATH**/ ?>