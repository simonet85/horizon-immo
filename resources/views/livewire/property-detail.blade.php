<div>
    <!-- Hero Section avec Slider d'Images -->
    <div class="relative h-96 bg-gray-900">
        @if($property->all_images && count($property->all_images) > 0)
            <!-- Image actuelle -->
            <img src="{{ $property->all_images[$currentImageIndex] }}" alt="{{ $property->title }}" class="w-full h-96 object-cover transition-opacity duration-500">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>

            <!-- Bouton Précédent -->
            @if(count($property->all_images) > 1)
            <button wire:click="previousImage" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-20 hover:bg-opacity-40 text-white p-3 rounded-full transition-all duration-200 backdrop-blur-sm z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <!-- Bouton Suivant -->
            <button wire:click="nextImage" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-20 hover:bg-opacity-40 text-white p-3 rounded-full transition-all duration-200 backdrop-blur-sm z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <!-- Compteur d'images -->
            <div class="absolute top-4 right-4 bg-black bg-opacity-50 text-white px-4 py-2 rounded-full text-sm font-medium backdrop-blur-sm z-10">
                {{ $currentImageIndex + 1 }} / {{ count($property->all_images) }}
            </div>

            <!-- Indicateurs points (dots) -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2 z-10">
                @foreach($property->all_images as $index => $image)
                    <button wire:click="goToImage({{ $index }})"
                            class="w-3 h-3 rounded-full transition-all duration-200 {{ $currentImageIndex === $index ? 'bg-white w-8' : 'bg-white bg-opacity-50 hover:bg-opacity-75' }}">
                    </button>
                @endforeach
            </div>
            @endif
        @else
            <div class="w-full h-96 bg-gradient-to-r from-blue-600 to-green-600"></div>
        @endif

        <!-- Titre et ville (overlay) -->
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
            <div class="text-center text-white">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ $property->title }}</h1>
                <p class="text-xl md:text-2xl opacity-90">{{ $property->town ? $property->town->name : $property->city }}</p>
            </div>
        </div>
    </div>

    <!-- Informations Principales -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Détails de la Propriété -->
            <div class="lg:col-span-2">
                <!-- Prix et Statut -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $property->formatted_price }}</h2>
                            <p class="text-gray-600 text-lg">{{ $property->address }}</p>
                        </div>
                        <div class="flex flex-col items-end space-y-2">
                            @if($property->status === 'available')
                                <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full font-medium">
                                    Disponible
                                </span>
                            @elseif($property->status === 'reserved')
                                <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full font-medium">
                                    Réservé
                                </span>
                            @else
                                <span class="px-4 py-2 bg-red-100 text-red-800 rounded-full font-medium">
                                    Vendu
                                </span>
                            @endif
                            
                            @if($property->is_featured)
                                <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full font-medium">
                                    ⭐ En vedette
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Caractéristiques -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        @if($property->category)
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">{{ $property->category->name }}</div>
                            <div class="text-gray-600">Catégorie</div>
                        </div>
                        @endif
                        @if($property->bedrooms)
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">{{ $property->bedrooms }}</div>
                            <div class="text-gray-600">Chambres</div>
                        </div>
                        @endif
                        @if($property->bathrooms)
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">{{ $property->bathrooms }}</div>
                            <div class="text-gray-600">Salles de bain</div>
                        </div>
                        @endif
                        @if($property->surface_area)
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">{{ number_format($property->surface_area, 0) }}</div>
                            <div class="text-gray-600">m²</div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Description</h3>
                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        {!! nl2br(e($property->description)) !!}
                    </div>
                </div>

                <!-- Galerie d'Images -->
                @if($property->all_images && count($property->all_images) > 1)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Galerie Photos</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($property->all_images as $index => $image)
                            <img src="{{ $image }}"
                                 alt="{{ $property->title }}"
                                 wire:click="openGallery({{ $index }})"
                                 class="w-full h-48 object-cover rounded-lg hover:scale-105 transition-transform duration-200 cursor-pointer">
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar Contact -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-4">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Intéressé par cette propriété ?</h3>
                    
                    <div class="space-y-4">
                        <a href="/contact?property={{ $property->id }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 text-center block">
                            Poser une Question sur ce Bien
                        </a>
                        
                        <a href="/accompagnement" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 text-center block">
                            Demander un Accompagnement
                        </a>
                        
                        <a href="/catalogue" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 text-center block">
                            Voir Plus de Propriétés
                        </a>
                    </div>

                    <!-- Informations de Contact
                     +225 0707 6969 14
                     +225 0545 0101 99
                     +27 65 868 7861
                     -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h4 class="font-semibold text-gray-900 mb-4">zb investments</h4>
                        <div class="space-y-3 text-sm text-gray-600">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                               Côte d'Ivoire
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                             +225 0707 6969 14
                             +225 0545 0101 99
                            </div>
                        </div>
                        <div class="space-y-3 text-sm text-gray-600">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                Afrique du Sud
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                                +27 65 868 7861
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                               info@zbinvestments-ci.com
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Propriétés Similaires -->
    @if($similarProperties && $similarProperties->count() > 0)
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Propriétés Similaires</h2>
                <p class="text-xl text-gray-600">Découvrez d'autres biens qui pourraient vous intéresser</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($similarProperties as $similarProperty)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group">
                    <!-- Image -->
                    <div class="relative h-64 overflow-hidden">
                        @if($similarProperty->all_images && count($similarProperty->all_images) > 0)
                            <img src="{{ $similarProperty->all_images[0] }}" alt="{{ $similarProperty->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        @else
                            <div class="w-full h-full bg-gradient-to-r from-blue-500 to-green-500 flex items-center justify-center">
                                <span class="text-white text-lg font-semibold">{{ $similarProperty->type }}</span>
                            </div>
                        @endif
                        
                        <!-- Badge statut -->
                        <div class="absolute top-4 left-4">
                            @if($similarProperty->status === 'available')
                                <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-medium">Disponible</span>
                            @elseif($similarProperty->status === 'reserved')
                                <span class="bg-yellow-600 text-white px-3 py-1 rounded-full text-sm font-medium">Réservé</span>
                            @else
                                <span class="bg-red-600 text-white px-3 py-1 rounded-full text-sm font-medium">Vendu</span>
                            @endif
                        </div>
                        
                        <!-- Badge vedette -->
                        @if($similarProperty->is_featured)
                        <div class="absolute top-4 right-4">
                            <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-medium">
                                ⭐ Vedette
                            </span>
                        </div>
                        @endif
                        
                        <!-- Prix -->
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-white text-gray-900 px-3 py-1 rounded-full text-sm font-bold">{{ $similarProperty->formatted_price }}</span>
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">{{ $similarProperty->title }}</h3>
                        <p class="text-gray-600 mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            {{ $similarProperty->town ? $similarProperty->town->name : $similarProperty->city }}
                        </p>

                        <!-- Caractéristiques -->
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                {{ ucfirst($similarProperty->type) }}
                            </span>
                            @if($similarProperty->bedrooms)
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                </svg>
                                {{ $similarProperty->bedrooms }} ch.
                            </span>
                            @endif
                            @if($similarProperty->surface_area)
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                </svg>
                                {{ number_format($similarProperty->surface_area, 0) }}m²
                            </span>
                            @endif
                        </div>

                        <!-- Description -->
                        <p class="text-gray-600 text-sm line-clamp-3 mb-4">{{ Str::limit($similarProperty->description, 120) }}</p>

                        <!-- Actions -->
                        <div class="flex space-x-2">
                            <a href="{{ route('property.detail', $similarProperty->id) }}" 
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-200 text-center text-sm">
                                Voir Détails
                            </a>
                            <a href="/contact?property={{ $similarProperty->id }}" 
                               class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-200 text-center text-sm">
                                Question
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Lien vers le catalogue -->
            <div class="text-center mt-12">
                <a href="/catalogue" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition-all duration-200 text-lg">
                    Voir Tout le Catalogue
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal Galerie avec Slider -->
    @if($showGalleryModal && $property->all_images && count($property->all_images) > 0)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-95 px-4 animate-fadeIn"
         wire:click="closeGallery">
        <div class="relative w-full max-w-6xl h-[80vh] flex items-center justify-center"
             @click.stop>

            <!-- Bouton Fermer -->
            <button wire:click="closeGallery"
                    class="absolute top-4 right-4 z-20 bg-white hover:bg-gray-100 text-gray-900 rounded-full p-3 transition-all duration-200 shadow-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Image principale -->
            <div class="relative w-full h-full flex items-center justify-center">
                <img src="{{ $property->all_images[$modalImageIndex] }}"
                     alt="{{ $property->title }}"
                     class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
            </div>

            <!-- Bouton Précédent -->
            @if(count($property->all_images) > 1)
            <button wire:click="previousModalImage"
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white hover:bg-gray-100 text-gray-900 p-4 rounded-full transition-all duration-200 shadow-lg z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <!-- Bouton Suivant -->
            <button wire:click="nextModalImage"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white hover:bg-gray-100 text-gray-900 p-4 rounded-full transition-all duration-200 shadow-lg z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            @endif

            <!-- Compteur d'images -->
            <div class="absolute top-4 left-4 bg-white text-gray-900 px-6 py-3 rounded-full text-lg font-bold shadow-lg z-20">
                {{ $modalImageIndex + 1 }} / {{ count($property->all_images) }}
            </div>

            <!-- Titre de la propriété -->
            <div class="absolute bottom-20 left-1/2 transform -translate-x-1/2 bg-black bg-opacity-70 text-white px-6 py-3 rounded-lg backdrop-blur-sm z-10">
                <h3 class="text-xl font-semibold text-center">{{ $property->title }}</h3>
            </div>

            <!-- Indicateurs points (dots) -->
            @if(count($property->all_images) > 1)
            <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-2 z-10 max-w-full overflow-x-auto px-4">
                @foreach($property->all_images as $index => $image)
                    <button wire:click="goToModalImage({{ $index }})"
                            class="flex-shrink-0 transition-all duration-200 {{ $modalImageIndex === $index ? 'w-10 h-3 bg-white rounded-full' : 'w-3 h-3 bg-white bg-opacity-50 hover:bg-opacity-75 rounded-full' }}">
                    </button>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
