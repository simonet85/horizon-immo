<?php

use App\Livewire\Actions\Logout;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: RouteServiceProvider::HOME, navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="animate-fade-in">
    <!-- Header with elegant typography -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-2xl mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2 tracking-tight">Vérifiez votre email</h1>
        <p class="text-gray-600 text-lg leading-relaxed max-w-lg mx-auto">
            Bienvenue ! Une dernière étape : vérifiez votre adresse email pour activer votre compte et accéder à toutes nos fonctionnalités.
        </p>
    </div>

    <!-- Status Message -->
    @if (session('status') == 'verification-link-sent')
        <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl animate-fade-in">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="ml-3 text-sm font-medium">
                    ✨ Parfait ! Un nouveau lien de vérification vient d'être envoyé à votre adresse email.
                </p>
            </div>
        </div>
    @endif

    <!-- Welcome Message -->
    <div class="mb-8 p-4 bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-200 rounded-xl">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-purple-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-semibold text-purple-800 mb-1">Inscription réussie !</h3>
                <p class="text-sm text-purple-700 leading-relaxed">
                    Votre compte a été créé avec succès. Il ne reste plus qu'à confirmer votre adresse email pour débloquer toutes les fonctionnalités.
                </p>
            </div>
        </div>
    </div>

    <!-- User Info -->
    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-800">
                    <strong>Email à vérifier:</strong> {{ Auth::user()->email ?? 'votre@email.com' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Instructions -->
    <div class="mb-8 p-4 bg-amber-50 border border-amber-200 rounded-xl">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-amber-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-semibold text-amber-800 mb-2">Étapes de vérification</h3>
                <div class="space-y-2 text-sm text-amber-700">
                    <div class="flex items-center">
                        <span class="inline-flex items-center justify-center w-5 h-5 bg-amber-600 text-white rounded-full text-xs font-bold mr-2">1</span>
                        <span>Ouvrez votre boîte mail</span>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-flex items-center justify-center w-5 h-5 bg-amber-600 text-white rounded-full text-xs font-bold mr-2">2</span>
                        <span>Cherchez l'email de "Immobilier SA"</span>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-flex items-center justify-center w-5 h-5 bg-amber-600 text-white rounded-full text-xs font-bold mr-2">3</span>
                        <span>Cliquez sur "Vérifier mon email"</span>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-flex items-center justify-center w-5 h-5 bg-amber-600 text-white rounded-full text-xs font-bold mr-2">4</span>
                        <span>Vous serez connecté automatiquement !</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="space-y-4">
        <!-- Resend Button -->
        <button wire:click="sendVerification" 
                class="w-full flex justify-center items-center py-4 px-6 border border-transparent rounded-xl text-base font-semibold text-white bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="sendVerification" class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Renvoyer l'email de vérification
            </span>
            <span wire:loading wire:target="sendVerification" class="flex items-center">
                <svg class="animate-spin -ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Envoi en cours...
            </span>
        </button>

        <!-- Logout Button -->
        <button wire:click="logout" 
                class="w-full flex justify-center items-center py-4 px-6 border-2 border-gray-300 rounded-xl text-base font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 transform hover:scale-[1.02]">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Se déconnecter
        </button>
    </div>

    <!-- Help Section -->
    <div class="mt-8">
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
            <div class="text-center mb-4">
                <h3 class="text-sm font-semibold text-gray-800 mb-2">🤔 Vous ne trouvez pas l'email ?</h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-600">
                <div class="space-y-2">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-gray-400 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <span>Vérifiez vos spams/courriers indésirables</span>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-gray-400 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <span>Attendez quelques minutes</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-gray-400 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <span>Vérifiez l'orthographe de votre email</span>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-gray-400 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <span>Essayez de renvoyer l'email</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Support -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-600 mb-3">Besoin d'aide supplémentaire ?</p>
            <a href="/contact" class="inline-flex items-center text-sm font-medium text-purple-600 hover:text-purple-800 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                Contacter notre équipe support
            </a>
        </div>

        <!-- Back to Home -->
        <div class="text-center pt-4 border-t border-gray-200 mt-6">
            <a href="/" wire:navigate class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour à l'accueil
            </a>
        </div>
    </div>
</div>
