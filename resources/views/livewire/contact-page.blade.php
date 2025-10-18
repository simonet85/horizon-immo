<div>
    <!-- Hero Section -->
    <section class="bg-blue-900 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Contactez-Nous</h1>
            <p class="text-xl md:text-2xl max-w-3xl mx-auto">
                Notre équipe d'experts est à votre disposition pour répondre à toutes vos questions sur l'immobilier en Afrique du Sud
            </p>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <!-- Contact Form -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <div class="flex items-center mb-6">
                        <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2v10a2 2 0 002 2z"/>
                        </svg>
                        <h2 class="text-2xl font-bold text-gray-900">
                            @if($property)
                                Question sur la propriété
                            @else
                                Envoyez-nous un message
                            @endif
                        </h2>
                    </div>

                    @if($property)
                        <!-- Informations sur la propriété -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <div class="flex items-start space-x-4">
                                @if($property->all_images && count($property->all_images) > 0)
                                    <img src="{{ $property->all_images[0] }}" alt="{{ $property->title }}" class="w-16 h-16 rounded-lg object-cover">
                                @else
                                    <div class="w-16 h-16 bg-blue-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $property->title }}</h3>
                                    <p class="text-sm text-gray-600">{{ $property->city }} • {{ $property->formatted_price }}</p>
                                    <a href="{{ route('property.detail', $property->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                        Voir les détails de cette propriété →
                                    </a>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-8">Posez votre question concernant cette propriété, nous vous répondrons rapidement.</p>
                    @else
                        <p class="text-gray-600 mb-8">Nous vous répondrons dans les plus brefs délais</p>
                    @endif

                    @if($showSuccess)
                    <div x-data="{ show: true }" x-show="show" x-transition class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        <div class="flex">
                            <div class="py-1">
                                <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold">
                                    @if($property)
                                        Question envoyée avec succès !
                                    @else
                                        Message envoyé avec succès !
                                    @endif
                                </p>
                                <p class="text-sm">
                                    @if($property)
                                        Votre question concernant cette propriété a été transmise à notre équipe.
                                    @else
                                        Nous vous recontacterons très prochainement.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <form wire:submit="sendMessage" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                                <input wire:model="first_name" type="text" id="first_name" placeholder="Votre prénom" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                @error('first_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                                <input wire:model="last_name" type="text" id="last_name" placeholder="Votre nom" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                @error('last_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input wire:model="email" type="email" id="email" placeholder="votre@email.com" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Téléphone *</label>
                            <input wire:model="phone" type="tel" id="phone" placeholder="+33 1 23 45 67 89" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Sujet *</label>
                            <input wire:model="subject" type="text" id="subject" placeholder="Objet de votre message" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                            <textarea wire:model="message" id="message" rows="6" placeholder="Décrivez votre projet ou posez votre question..." 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                            @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full btn-primary">
                            <svg wire:loading wire:target="sendMessage" class="inline w-4 h-4 mr-2 animate-spin" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                            </svg>
                            <span wire:loading.remove wire:target="sendMessage">Envoyer le message</span>
                            <span wire:loading wire:target="sendMessage">Envoi en cours...</span>
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div>
                    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Informations de Contact</h3>
                        
                        <div class="space-y-6">
                            <!-- Address -->
                            <div class="flex items-start">
                                <div class="bg-blue-100 p-3 rounded-lg mr-4">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">Adresse</h4>
                                    <p class="text-gray-600">Afrique du Sud</p>
                                    <!-- <p class="text-gray-600">75001 Paris, France</p> -->
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="flex items-start">
                                <div class="bg-green-100 p-3 rounded-lg mr-4">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">Téléphone</h4>
                                    <p class="text-gray-600">+225 07 07 69 69 14</p>
                                    <p class="text-gray-600">+225 05 45 01 01 99</p>
                                    <p class="text-gray-600">+27 65 86 87 861 (Afrique du Sud)</p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="flex items-start">
                                <div class="bg-yellow-100 p-3 rounded-lg mr-4">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">Email</h4>
                                    <p class="text-gray-600">info@zbinvestments-ci.com</p>
                                    <!-- <p class="text-gray-600">mr.gnual@immobilier-sa.com</p> -->
                                </div>
                            </div>

                            <!-- Hours -->
                            <div class="flex items-start">
                                <div class="bg-purple-100 p-3 rounded-lg mr-4">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">Horaires</h4>
                                    <p class="text-gray-600">Lundi - Vendredi: 9h - 18h</p>
                                    <p class="text-gray-600">Samedi: 9h - 13h</p>
                                    <p class="text-gray-600">Dimanche: Fermé</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Why Choose Us -->
                    <div class="bg-blue-900 text-white rounded-xl p-8">
                        <h3 class="text-2xl font-bold mb-6">Pourquoi Nous Choisir ?</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Expertise locale en Afrique du Sud</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Accompagnement personnalisé</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Partenaire Standard Bank</span>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-blue-800">
                            <h4 class="font-semibold text-yellow-400 mb-2">Partenaire Officiel</h4>
                            <div class="bg-white text-blue-900 px-3 py-1 rounded text-sm font-medium inline-block">
                                Standard Bank
                            </div>
                            <p class="text-xs text-gray-300 mt-1">Solutions de financement privilégiées</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('hideSuccess', () => {
                setTimeout(() => {
                    @this.showSuccess = false;
                }, 5000);
            });
        });
    </script>
</div>
