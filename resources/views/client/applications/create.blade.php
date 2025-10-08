@extends('layouts.admin')

@section('title', 'Nouvelle Demande d\'Accompagnement')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('client.applications.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                ← Retour aux applications
            </a>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-4">Nouvelle Demande d'Accompagnement</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">
                Remplissez ce formulaire pour soumettre votre demande d'accompagnement immobilier.
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
            <form action="{{ route('client.applications.store') }}" method="POST">
                @csrf

                <!-- Informations personnelles -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Informations personnelles</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Prénom <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="first_name" 
                                   name="first_name" 
                                   value="{{ old('first_name') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   required>
                            @error('first_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nom <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="last_name" 
                                   name="last_name" 
                                   value="{{ old('last_name') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   required>
                            @error('last_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="country_residence" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Pays de résidence <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="country_residence" 
                                   name="country_residence" 
                                   value="{{ old('country_residence') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   required>
                            @error('country_residence')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="age" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Âge <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   id="age" 
                                   name="age" 
                                   value="{{ old('age') }}"
                                   min="18" 
                                   max="120"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   required>
                            @error('age')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="profession" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Profession <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="profession" 
                                   name="profession" 
                                   value="{{ old('profession') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   required>
                            @error('profession')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Téléphone <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   required>
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Projet immobilier -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Votre projet immobilier</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="desired_city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Ville désirée <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="desired_city" 
                                   name="desired_city" 
                                   value="{{ old('desired_city') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   required>
                            @error('desired_city')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="property_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Type de bien <span class="text-red-500">*</span>
                            </label>
                            <select id="property_type" 
                                    name="property_type" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                    required>
                                <option value="">Sélectionnez un type</option>
                                <option value="Appartement" {{ old('property_type') == 'Appartement' ? 'selected' : '' }}>Appartement</option>
                                <option value="Maison" {{ old('property_type') == 'Maison' ? 'selected' : '' }}>Maison</option>
                                <option value="Villa" {{ old('property_type') == 'Villa' ? 'selected' : '' }}>Villa</option>
                                <option value="Studio" {{ old('property_type') == 'Studio' ? 'selected' : '' }}>Studio</option>
                                <option value="Loft" {{ old('property_type') == 'Loft' ? 'selected' : '' }}>Loft</option>
                                <option value="Duplex" {{ old('property_type') == 'Duplex' ? 'selected' : '' }}>Duplex</option>
                                <option value="Autre" {{ old('property_type') == 'Autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('property_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="budget_range" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Fourchette budgétaire <span class="text-red-500">*</span>
                            </label>
                            <select id="budget_range" 
                                    name="budget_range" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                    required>
                                <option value="">Sélectionnez une fourchette</option>
                                <option value="Moins de 100 000€" {{ old('budget_range') == 'Moins de 100 000€' ? 'selected' : '' }}>Moins de 100 000€</option>
                                <option value="100 000€ - 200 000€" {{ old('budget_range') == '100 000€ - 200 000€' ? 'selected' : '' }}>100 000€ - 200 000€</option>
                                <option value="200 000€ - 300 000€" {{ old('budget_range') == '200 000€ - 300 000€' ? 'selected' : '' }}>200 000€ - 300 000€</option>
                                <option value="300 000€ - 500 000€" {{ old('budget_range') == '300 000€ - 500 000€' ? 'selected' : '' }}>300 000€ - 500 000€</option>
                                <option value="500 000€ - 1 000 000€" {{ old('budget_range') == '500 000€ - 1 000 000€' ? 'selected' : '' }}>500 000€ - 1 000 000€</option>
                                <option value="Plus de 1 000 000€" {{ old('budget_range') == 'Plus de 1 000 000€' ? 'selected' : '' }}>Plus de 1 000 000€</option>
                            </select>
                            @error('budget_range')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="personal_contribution_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Apport personnel (%) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   id="personal_contribution_percentage" 
                                   name="personal_contribution_percentage" 
                                   value="{{ old('personal_contribution_percentage') }}"
                                   min="0" 
                                   max="100"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   required>
                            @error('personal_contribution_percentage')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Informations complémentaires -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Informations complémentaires</h2>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="additional_info" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Informations supplémentaires
                            </label>
                            <textarea id="additional_info" 
                                      name="additional_info" 
                                      rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                      placeholder="Ajoutez toute information que vous jugez utile pour votre projet...">{{ old('additional_info') }}</textarea>
                            @error('additional_info')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Message personnel
                            </label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                      placeholder="Décrivez votre projet, vos attentes ou posez vos questions...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('client.applications.index') }}" 
                       class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Soumettre la demande
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
