<div>
    <!-- Hero Section -->
    <section class="bg-blue-900 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Demande d'Accompagnement</h1>
            <p class="text-xl md:text-2xl max-w-3xl mx-auto">
                Étape {{ $currentStep }} sur {{ $totalSteps }}
            </p>
        </div>
    </section>

    <!-- Progress Bar -->
    <section class="bg-white py-4 shadow-sm">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                @for($i = 1; $i <= $totalSteps; $i++)
                <div class="flex items-center {{ $i < $totalSteps ? 'flex-1' : '' }}">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full {{ $currentStep >= $i ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600' }}">
                        {{ $i }}
                    </div>
                    @if($i < $totalSteps)
                    <div class="flex-1 h-1 mx-4 {{ $currentStep > $i ? 'bg-blue-600' : 'bg-gray-300' }}"></div>
                    @endif
                </div>
                @endfor
            </div>
        </div>
    </section>

    @if($showSuccess)
    <!-- Success Message -->
    <section class="py-20 bg-green-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Demande envoyée avec succès !</h2>
                <p class="text-xl text-gray-600 mb-8">
                    Votre demande d'accompagnement a été transmise à notre équipe. Nous vous recontacterons dans les plus brefs délais pour discuter de votre projet.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/" class="btn-primary">Retour à l'accueil</a>
                    <a href="/catalogue" class="btn-secondary">Parcourir le catalogue</a>
                </div>
            </div>
        </div>
    </section>
    @else
    <!-- Form Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        @if($currentStep == 1)
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        @elseif($currentStep == 2)
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        @else
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        @endif
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $this->stepTitle }}</h2>
                    <p class="text-gray-600">{{ $this->stepDescription }}</p>
                </div>

                <form wire:submit="{{ $currentStep == $totalSteps ? 'submitRequest' : 'nextStep' }}">
                    @if($currentStep == 1)
                    <!-- Step 1: Personal Information -->
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                                <input wire:model="first_name" type="text" id="first_name" placeholder="Votre prénom" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('first_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                                <input wire:model="last_name" type="text" id="last_name" placeholder="Votre nom" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('last_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="country_residence" class="block text-sm font-medium text-gray-700 mb-2">Pays de résidence *</label>
                                <select wire:model="country_residence" id="country_residence" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Sélectionner votre pays</option>
                                    <option value="France">France</option>
                                    <option value="Belgique">Belgique</option>
                                    <option value="Suisse">Suisse</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Autre">Autre</option>
                                </select>
                                @error('country_residence') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="age" class="block text-sm font-medium text-gray-700 mb-2">Âge *</label>
                                <input wire:model="age" type="number" id="age" placeholder="Votre âge" min="18" max="100"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('age') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="profession" class="block text-sm font-medium text-gray-700 mb-2">Profession *</label>
                            <input wire:model="profession" type="text" id="profession" placeholder="Votre profession" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('profession') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input wire:model="email" type="email" id="email" placeholder="votre@email.com" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Téléphone *</label>
                                <input wire:model="phone" type="tel" id="phone" placeholder="+33 1 23 45 67 89" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    @elseif($currentStep == 2)
                    <!-- Step 2: Project Information -->
                    <div class="space-y-6">
                        <div>
                            <label for="desired_city" class="block text-sm font-medium text-gray-700 mb-2">Ville souhaitée *</label>
                            <select wire:model="desired_city" id="desired_city" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Sélectionner une ville</option>
                                <option value="Cape Town">Le Cap</option>
                                <option value="Johannesburg">Johannesburg</option>
                                <option value="Pretoria">Pretoria</option>
                                <option value="Durban">Durban</option>
                                <option value="Stellenbosch">Stellenbosch</option>
                                <option value="Hermanus">Hermanus</option>
                                <option value="Autre">Autre ville</option>
                            </select>
                            @error('desired_city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="property_type" class="block text-sm font-medium text-gray-700 mb-2">Type de bien *</label>
                            <select wire:model="property_type" id="property_type" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Sélectionner le type de bien</option>
                                <option value="Villa">Villa</option>
                                <option value="Appartement">Appartement</option>
                                <option value="Maison familiale">Maison familiale</option>
                                <option value="Penthouse">Penthouse</option>
                                <option value="Terrain">Terrain</option>
                                <option value="Investissement locatif">Investissement locatif</option>
                            </select>
                            @error('property_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="budget_range" class="block text-sm font-medium text-gray-700 mb-2">Budget estimé (ZAR) *</label>
                            <select wire:model="budget_range" id="budget_range" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Sélectionner votre budget</option>
                                <option value="500 000 - 1 000 000">500 000 - 1 000 000 ZAR</option>
                                <option value="1 000 000 - 2 000 000">1 000 000 - 2 000 000 ZAR</option>
                                <option value="2 000 000 - 5 000 000">2 000 000 - 5 000 000 ZAR</option>
                                <option value="5 000 000 - 10 000 000">5 000 000 - 10 000 000 ZAR</option>
                                <option value="Plus de 10 000 000">Plus de 10 000 000 ZAR</option>
                            </select>
                            @error('budget_range') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="additional_info" class="block text-sm font-medium text-gray-700 mb-2">Informations complémentaires</label>
                            <textarea wire:model="additional_info" id="additional_info" rows="4" 
                                      placeholder="Décrivez vos critères spécifiques, vos attentes..." 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                        </div>
                    </div>
                    @else
                    <!-- Step 3: Financial Information -->
                    <div class="space-y-6">
                        <div>
                            <label for="personal_contribution" class="block text-sm font-medium text-gray-700 mb-4">
                                Apport personnel: {{ $personal_contribution_percentage }}%
                            </label>
                            <div class="px-3">
                                <input wire:model.live="personal_contribution_percentage" type="range" 
                                       min="10" max="100" step="5" id="personal_contribution"
                                       class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider">
                                <div class="flex justify-between text-sm text-gray-500 mt-2">
                                    <span>10%</span>
                                    <span>30%</span>
                                    <span>50%</span>
                                    <span>70%</span>
                                    <span>100%</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-blue-50 p-6 rounded-lg">
                            <h3 class="font-semibold text-blue-900 mb-3">Simulation Financière</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Budget sélectionné:</span>
                                    <span class="font-medium text-blue-900">{{ $budget_range ?: 'Non défini' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Apport personnel ({{ $personal_contribution_percentage }}%):</span>
                                    <span class="font-medium text-green-600">À calculer</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Financement requis:</span>
                                    <span class="font-medium text-blue-600">À calculer</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Mensualité estimée:</span>
                                    <span class="font-medium text-blue-600">À calculer</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-3">
                                * Simulation basée sur les taux Standard Bank. Un conseiller vous contactera pour une évaluation précise.
                            </p>
                        </div>
                    </div>
                    @endif

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between pt-8 mt-8 border-t">
                        @if($currentStep > 1)
                        <button type="button" wire:click="previousStep" class="btn-outline">
                            ← Précédent
                        </button>
                        @else
                        <div></div>
                        @endif

                        @if($currentStep < $totalSteps)
                        <button type="submit" class="btn-primary">
                            Suivant →
                        </button>
                        @else
                        <button type="submit" class="btn-primary">
                            <svg wire:loading wire:target="submitRequest" class="inline w-4 h-4 mr-2 animate-spin" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                            </svg>
                            <span wire:loading.remove wire:target="submitRequest">Envoyer ma demande</span>
                            <span wire:loading wire:target="submitRequest">Envoi en cours...</span>
                        </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </section>
    @endif

    <style>
        .slider::-webkit-slider-thumb {
            appearance: none;
            width: 20px;
            height: 20px;
            background: #3B82F6;
            cursor: pointer;
            border-radius: 50%;
        }

        .slider::-moz-range-thumb {
            width: 20px;
            height: 20px;
            background: #3B82F6;
            cursor: pointer;
            border-radius: 50%;
            border: none;
        }
    </style>
</div>
