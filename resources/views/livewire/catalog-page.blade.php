<div>
    <!-- Hero Section -->
    <section class="bg-blue-900 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Catalogue des Propriétés</h1>
            <p class="text-xl md:text-2xl max-w-3xl mx-auto">
                Découvrez notre sélection exclusive de biens immobiliers en Afrique du Sud
            </p>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="bg-white py-8 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-50 rounded-xl p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Titre, description..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                        <select wire:model.live="selectedCategoryId"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Location Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                        <select wire:model.live="selectedCity"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Toutes les villes</option>
                            @foreach($towns as $town)
                                <option value="{{ $town->name }}">{{ $town->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Budget (FCFA)</label>
                        <select wire:model.live="priceRange"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Tous les prix</option>
                            <option value="0-50000000">Moins de 50M FCFA</option>
                            <option value="50000000-100000000">50M - 100M FCFA</option>
                            <option value="100000000-200000000">100M - 200M FCFA</option>
                            <option value="200000000-300000000">200M - 300M FCFA</option>
                            <option value="300000000-999999999999">Plus de 300M FCFA</option>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                        <select wire:model.live="selectedStatus" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Tous les statuts</option>
                            <option value="available">Disponible</option>
                            <option value="reserved">Réservé</option>
                            <option value="sold">Vendu</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-4">
                    <!-- Sort Options -->
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-gray-700">Trier par:</span>
                        <button wire:click="setSortBy('price')" 
                                class="px-3 py-1 rounded-lg text-sm transition-colors {{ $sortBy === 'price' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}"
                                type="button">
                            Prix
                            @if($sortBy === 'price')
                                <span class="ml-1">@if($sortDirection === 'asc') ↑ @else ↓ @endif</span>
                            @endif
                        </button>
                        <button wire:click="setSortBy('created_at')" 
                                class="px-3 py-1 rounded-lg text-sm transition-colors {{ $sortBy === 'created_at' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}"
                                type="button">
                            Date
                            @if($sortBy === 'created_at')
                                <span class="ml-1">@if($sortDirection === 'asc') ↑ @else ↓ @endif</span>
                            @endif
                        </button>
                        <button wire:click="setSortBy('title')" 
                                class="px-3 py-1 rounded-lg text-sm transition-colors {{ $sortBy === 'title' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}"
                                type="button">
                            Nom
                            @if($sortBy === 'title')
                                <span class="ml-1">@if($sortDirection === 'asc') ↑ @else ↓ @endif</span>
                            @endif
                        </button>
                    </div>

                    <!-- Clear Filters -->
                    <button wire:click="resetFilters" 
                            class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg border border-gray-300 transition-colors"
                            type="button">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Effacer les filtres
                    </button>

                    <!-- Results count -->
                    <div class="ml-auto">
                        <span class="text-sm text-gray-600">{{ $properties->total() }} propriété(s) trouvée(s)</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Properties Grid -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($properties->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($properties as $property)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="relative">
                        <img src="{{ $property->main_image }}" alt="{{ $property->title }}" class="w-full h-64 object-cover">
                        <div class="absolute top-4 left-4">
                            @if($property->status === 'available')
                                <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-medium">Disponible</span>
                            @elseif($property->status === 'reserved')
                                <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-medium">Réservé</span>
                            @elseif($property->status === 'sold')
                                <span class="bg-red-600 text-white px-3 py-1 rounded-full text-sm font-medium">Vendu</span>
                            @else
                                <span class="bg-gray-500 text-white px-3 py-1 rounded-full text-sm font-medium">{{ ucfirst($property->status) }}</span>
                            @endif
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="bg-white text-gray-900 px-3 py-1 rounded-full text-sm font-bold">{{ $property->formatted_price }}</span>
                        </div>
                        @if($property->is_featured)
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-medium">
                                ⭐ En vedette
                            </span>
                        </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $property->title }}</h3>
                        <p class="text-gray-600 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            {{ optional($property->town)->name ?? $property->city }}
                        </p>
                        
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($property->description, 100) }}</p>
                        
                        <div class="flex justify-between text-sm text-gray-500 mb-4">
                            @if($property->bedrooms)
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                                {{ $property->bedrooms }} ch.
                            </span>
                            @endif
                            
                            @if($property->bathrooms)
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                                {{ $property->bathrooms }} sdb
                            </span>
                            @endif
                            
                            @if($property->surface_area)
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 6.707 6.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                {{ number_format($property->surface_area, 0) }} m²
                            </span>
                            @endif
                        </div>
                        
                        <div class="flex justify-between items-center">
                            @if($property->category)
                            <span class="text-sm text-blue-600 font-medium bg-blue-50 px-3 py-1 rounded-full">{{ $property->category->name }}</span>
                            @endif
                            <div class="flex space-x-2">
                                <button class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </button>
                                <a href="{{ route('property.detail', $property->id) }}" class="btn-primary text-sm py-2 px-3">
                                    Détails
                                </a>
                                <a href="/contact?property={{ $property->id }}" class="btn-primary text-sm py-2 px-3">
                                    Question
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $properties->links() }}
            </div>
            @else
            <!-- No Properties Found -->
            <div class="text-center py-16">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune propriété trouvée</h3>
                <p class="text-gray-600 mb-6">Essayez de modifier vos critères de recherche ou contactez-nous pour des biens sur mesure.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button wire:click="resetFilters" class="btn-outline inline-flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Effacer les filtres
                    </button>
                    <a href="/contact" class="btn-primary">
                        Nous contacter
                    </a>
                </div>
            </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-blue-900 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Vous ne trouvez pas ce que vous cherchez ?</h2>
            <p class="text-xl mb-8">
                Notre équipe peut vous aider à trouver la propriété parfaite selon vos critères spécifiques.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/accompagnement" class="border-2 border-white text-white hover:bg-white hover:text-blue-900 font-medium py-3 px-8 rounded-lg transition-all duration-200">
                    Demande personnalisée
                </a>
                <a href="/contact" class="border-2 border-white text-white hover:bg-white hover:text-blue-900 font-medium py-3 px-8 rounded-lg transition-all duration-200">
                    Nous contacter
                </a>
            </div>
        </div>
    </section>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</div>
