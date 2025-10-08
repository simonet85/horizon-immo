@extends('layouts.admin')

@section('title', 'Modifier demande #' . $application->id)

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.applications.show', $application) }}" 
           class="text-gray-600 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Modifier demande #{{ $application->id }}</h1>
            <p class="text-gray-600 mt-1">{{ $application->fullName }} - {{ $application->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <!-- Formulaire -->
    <form action="{{ route('admin.applications.update', $application) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Statut -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Statut de la demande</h2>
            </div>
            <div class="px-6 py-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select name="status" 
                            id="status" 
                            class="mt-1 block w-full max-w-xs rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="processing" {{ $application->status === 'processing' ? 'selected' : '' }}>En cours</option>
                        <option value="completed" {{ $application->status === 'completed' ? 'selected' : '' }}>Terminée</option>
                        <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejetée</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Informations personnelles -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Informations personnelles</h2>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom *</label>
                        <input type="text" 
                               name="first_name" 
                               id="first_name" 
                               value="{{ old('first_name', $application->first_name) }}"
                               class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('first_name') border-red-300 @else border-gray-300 @enderror">
                        @error('first_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Nom *</label>
                        <input type="text" 
                               name="last_name" 
                               id="last_name" 
                               value="{{ old('last_name', $application->last_name) }}"
                               class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('last_name') border-red-300 @else border-gray-300 @enderror">
                        @error('last_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email', $application->email) }}"
                               class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-300 @else border-gray-300 @enderror">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <input type="tel" 
                               name="phone" 
                               id="phone" 
                               value="{{ old('phone', $application->phone) }}"
                               class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('phone') border-red-300 @else border-gray-300 @enderror">
                        @error('phone')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700">Âge</label>
                        <input type="number" 
                               name="age" 
                               id="age" 
                               min="18" 
                               max="120"
                               value="{{ old('age', $application->age) }}"
                               class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('age') border-red-300 @else border-gray-300 @enderror">
                        @error('age')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="country_residence" class="block text-sm font-medium text-gray-700">Pays de résidence</label>
                        <select name="country_residence" 
                                id="country_residence" 
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('country_residence') border-red-300 @else border-gray-300 @enderror">
                            <option value="">Sélectionner votre pays</option>
                            <option value="France" {{ old('country_residence', $application->country_residence) === 'France' ? 'selected' : '' }}>France</option>
                            <option value="Belgique" {{ old('country_residence', $application->country_residence) === 'Belgique' ? 'selected' : '' }}>Belgique</option>
                            <option value="Suisse" {{ old('country_residence', $application->country_residence) === 'Suisse' ? 'selected' : '' }}>Suisse</option>
                            <option value="Canada" {{ old('country_residence', $application->country_residence) === 'Canada' ? 'selected' : '' }}>Canada</option>
                            <option value="Autre" {{ old('country_residence', $application->country_residence) === 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('country_residence')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="profession" class="block text-sm font-medium text-gray-700">Profession</label>
                        <input type="text" 
                               name="profession" 
                               id="profession" 
                               value="{{ old('profession', $application->profession) }}"
                               class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('profession') border-red-300 @else border-gray-300 @enderror">
                        @error('profession')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Projet immobilier -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Projet immobilier</h2>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="property_type" class="block text-sm font-medium text-gray-700">Type de bien *</label>
                        <select name="property_type" 
                                id="property_type" 
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('property_type') border-red-300 @else border-gray-300 @enderror">
                            <option value="">Sélectionner un type</option>
                            <option value="Appartement" {{ old('property_type', $application->property_type) === 'Appartement' ? 'selected' : '' }}>Appartement</option>
                            <option value="Maison" {{ old('property_type', $application->property_type) === 'Maison' ? 'selected' : '' }}>Maison</option>
                            <option value="Studio" {{ old('property_type', $application->property_type) === 'Studio' ? 'selected' : '' }}>Studio</option>
                            <option value="Local commercial" {{ old('property_type', $application->property_type) === 'Local commercial' ? 'selected' : '' }}>Local commercial</option>
                            <option value="Terrain" {{ old('property_type', $application->property_type) === 'Terrain' ? 'selected' : '' }}>Terrain</option>
                            <option value="Autre" {{ old('property_type', $application->property_type) === 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('property_type')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="desired_city" class="block text-sm font-medium text-gray-700">Ville souhaitée *</label>
                        <select name="desired_city" 
                                id="desired_city" 
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('desired_city') border-red-300 @else border-gray-300 @enderror">
                            <option value="">Sélectionner une ville</option>
                            <option value="Cape Town" {{ old('desired_city', $application->desired_city) === 'Cape Town' ? 'selected' : '' }}>Le Cap</option>
                            <option value="Johannesburg" {{ old('desired_city', $application->desired_city) === 'Johannesburg' ? 'selected' : '' }}>Johannesburg</option>
                            <option value="Pretoria" {{ old('desired_city', $application->desired_city) === 'Pretoria' ? 'selected' : '' }}>Pretoria</option>
                            <option value="Durban" {{ old('desired_city', $application->desired_city) === 'Durban' ? 'selected' : '' }}>Durban</option>
                            <option value="Stellenbosch" {{ old('desired_city', $application->desired_city) === 'Stellenbosch' ? 'selected' : '' }}>Stellenbosch</option>
                            <option value="Hermanus" {{ old('desired_city', $application->desired_city) === 'Hermanus' ? 'selected' : '' }}>Hermanus</option>
                            <option value="Autre" {{ old('desired_city', $application->desired_city) === 'Autre' ? 'selected' : '' }}>Autre ville</option>
                        </select>
                        @error('desired_city')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="budget_range" class="block text-sm font-medium text-gray-700">Budget *</label>
                        <select name="budget_range" 
                                id="budget_range" 
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('budget_range') border-red-300 @else border-gray-300 @enderror">
                            <option value="">Sélectionner un budget</option>
                            <option value="Moins de 100 000€" {{ old('budget_range', $application->budget_range) === 'Moins de 100 000€' ? 'selected' : '' }}>Moins de 100 000€</option>
                            <option value="100 000€ - 200 000€" {{ old('budget_range', $application->budget_range) === '100 000€ - 200 000€' ? 'selected' : '' }}>100 000€ - 200 000€</option>
                            <option value="200 000€ - 300 000€" {{ old('budget_range', $application->budget_range) === '200 000€ - 300 000€' ? 'selected' : '' }}>200 000€ - 300 000€</option>
                            <option value="300 000€ - 500 000€" {{ old('budget_range', $application->budget_range) === '300 000€ - 500 000€' ? 'selected' : '' }}>300 000€ - 500 000€</option>
                            <option value="500 000€ - 1 000 000€" {{ old('budget_range', $application->budget_range) === '500 000€ - 1 000 000€' ? 'selected' : '' }}>500 000€ - 1 000 000€</option>
                            <option value="Plus de 1 000 000€" {{ old('budget_range', $application->budget_range) === 'Plus de 1 000 000€' ? 'selected' : '' }}>Plus de 1 000 000€</option>
                        </select>
                        @error('budget_range')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="investment_type" class="block text-sm font-medium text-gray-700">Type d'investissement</label>
                        <select name="investment_type" 
                                id="investment_type" 
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('investment_type') border-red-300 @else border-gray-300 @enderror">
                            <option value="">Sélectionner un type</option>
                            <option value="Résidence principale" {{ old('investment_type', $application->investment_type) === 'Résidence principale' ? 'selected' : '' }}>Résidence principale</option>
                            <option value="Résidence secondaire" {{ old('investment_type', $application->investment_type) === 'Résidence secondaire' ? 'selected' : '' }}>Résidence secondaire</option>
                            <option value="Investissement locatif" {{ old('investment_type', $application->investment_type) === 'Investissement locatif' ? 'selected' : '' }}>Investissement locatif</option>
                            <option value="Autre" {{ old('investment_type', $application->investment_type) === 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('investment_type')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="financial_situation" class="block text-sm font-medium text-gray-700">Situation financière</label>
                        <select name="financial_situation" 
                                id="financial_situation" 
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('financial_situation') border-red-300 @else border-gray-300 @enderror">
                            <option value="">Sélectionner une situation</option>
                            <option value="Financement personnel" {{ old('financial_situation', $application->financial_situation) === 'Financement personnel' ? 'selected' : '' }}>Financement personnel</option>
                            <option value="Crédit immobilier" {{ old('financial_situation', $application->financial_situation) === 'Crédit immobilier' ? 'selected' : '' }}>Crédit immobilier</option>
                            <option value="Mixte" {{ old('financial_situation', $application->financial_situation) === 'Mixte' ? 'selected' : '' }}>Mixte</option>
                            <option value="En cours d'étude" {{ old('financial_situation', $application->financial_situation) === 'En cours d\'étude' ? 'selected' : '' }}>En cours d'étude</option>
                        </select>
                        @error('financial_situation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="investment_goal" class="block text-sm font-medium text-gray-700">Objectif d'investissement</label>
                        <input type="text" 
                               name="investment_goal" 
                               id="investment_goal" 
                               value="{{ old('investment_goal', $application->investment_goal) }}"
                               placeholder="Ex: Rendement locatif, Plus-value, Défiscalisation..."
                               class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('investment_goal') border-red-300 @else border-gray-300 @enderror">
                        @error('investment_goal')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Message -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Message complémentaire</h2>
            </div>
            <div class="px-6 py-4">
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                    <textarea name="message" 
                              id="message" 
                              rows="4" 
                              placeholder="Informations complémentaires, besoins spécifiques..."
                              class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('message') border-red-300 @else border-gray-300 @enderror">{{ old('message', $application->message) }}</textarea>
                    @error('message')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.applications.show', $application) }}" 
               class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg font-medium">
                Annuler
            </a>
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection
