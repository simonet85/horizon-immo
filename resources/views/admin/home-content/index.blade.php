@extends('layouts.admin')

@section('title', 'Gestion du Contenu Site')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Gestion du Contenu du Site</h2>
        
        <!-- Navigation entre les sections -->
        <div class="border-b border-gray-200 mb-6" x-data="{ activeTab: 'hero' }">
            <nav class="-mb-px flex space-x-8">
                <button @click="activeTab = 'hero'" 
                        :class="activeTab === 'hero' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="py-2 px-1 border-b-2 font-medium text-sm">
                    Section Hero
                </button>
                <button @click="activeTab = 'navigation'" 
                        :class="activeTab === 'navigation' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="py-2 px-1 border-b-2 font-medium text-sm">
                    Navigation/Logo
                </button>
                <button @click="activeTab = 'services'" 
                        :class="activeTab === 'services' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="py-2 px-1 border-b-2 font-medium text-sm">
                    Services
                </button>
                <button @click="activeTab = 'process'" 
                        :class="activeTab === 'process' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="py-2 px-1 border-b-2 font-medium text-sm">
                    Processus
                </button>
                <button @click="activeTab = 'testimonials'" 
                        :class="activeTab === 'testimonials' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="py-2 px-1 border-b-2 font-medium text-sm">
                    Témoignages
                </button>
                <button @click="activeTab = 'partners'" 
                        :class="activeTab === 'partners' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="py-2 px-1 border-b-2 font-medium text-sm">
                    Partenaires
                </button>
                <button @click="activeTab = 'cta'" 
                        :class="activeTab === 'cta' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="py-2 px-1 border-b-2 font-medium text-sm">
                    Call to Action
                </button>
                <button @click="activeTab = 'contact'" 
                        :class="activeTab === 'contact' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="py-2 px-1 border-b-2 font-medium text-sm">
                    Contact
                </button>
                <button @click="activeTab = 'footer'" 
                        :class="activeTab === 'footer' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="py-2 px-1 border-b-2 font-medium text-sm">
                    Footer
                </button>
            </nav>

            <!-- Section Hero -->
            <div x-show="activeTab === 'hero'" class="mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Section Hero (Bannière principale)</h3>
                <form action="{{ route('admin.home-content.update-hero') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Titre Principal</label>
                            <input type="text" id="title" name="title" 
                                   value="{{ $hero['titre_principal']->value ?? 'Votre Rêve Immobilier en Afrique du Sud' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">Sous-titre</label>
                            <textarea id="subtitle" name="subtitle" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $hero['sous_titre']->value ?? 'Courtage, accompagnement financier et conseils personnalisés pour votre acquisition immobilière en toute sérénité' }}</textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="button_1_text" class="block text-sm font-medium text-gray-700 mb-2">Texte Bouton Principal</label>
                            <input type="text" id="button_1_text" name="button_1_text" 
                                   value="{{ $hero['bouton_principal_text']->value ?? 'Découvrir nos Biens' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="button_1_url" class="block text-sm font-medium text-gray-700 mb-2">URL Bouton Principal</label>
                            <input type="text" id="button_1_url" name="button_1_url" 
                                   value="{{ $hero['bouton_principal_url']->value ?? '/catalogue' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                   placeholder="Ex: /properties, https://example.com">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="button_2_text" class="block text-sm font-medium text-gray-700 mb-2">Texte Bouton Secondaire</label>
                            <input type="text" id="button_2_text" name="button_2_text" 
                                   value="{{ $hero['bouton_secondaire_text']->value ?? 'Accompagnement Financier' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="button_2_url" class="block text-sm font-medium text-gray-700 mb-2">URL Bouton Secondaire</label>
                            <input type="text" id="button_2_url" name="button_2_url" 
                                   value="{{ $hero['bouton_secondaire_url']->value ?? '/accompagnement' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Ex: /services, https://example.com">
                        </div>
                    </div>

                    <!-- Image de fond -->
                    <div class="mt-6">
                        <label for="background_image" class="block text-sm font-medium text-gray-700 mb-2">Image de fond</label>
                        
                        @if(isset($hero['background_image']) && $hero['background_image']->image_path)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Image actuelle :</p>
                                <img src="{{ asset('storage/' . $hero['background_image']->image_path) }}" 
                                     alt="Image Hero actuelle" 
                                     class="w-32 h-20 object-cover rounded-lg border">
                            </div>
                        @endif

                        <input type="file" id="background_image" name="background_image" 
                               accept="image/jpeg,image/jpg,image/png,image/webp"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-sm text-gray-500 mt-1">Formats acceptés : JPG, JPEG, PNG, WebP. Taille max : 5MB</p>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                            Mettre à jour la section Hero
                        </button>
                    </div>
                </form>
            </div>

            <!-- Section Navigation/Logo -->
            <div x-show="activeTab === 'navigation'" class="mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Navigation et Logo</h3>
                <form action="{{ route('admin.home-content.update-logo') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">Logo du site</label>
                        
                        @if(isset($navigation['logo']) && $navigation['logo']->image_path)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Logo actuel :</p>
                                <img src="{{ asset('storage/' . $navigation['logo']->image_path) }}" 
                                     alt="Logo actuel" 
                                     class="h-16 w-auto object-contain border rounded-lg p-2 bg-white">
                            </div>
                        @endif

                        <input type="file" id="logo" name="logo" 
                               accept="image/jpeg,image/jpg,image/png,image/svg+xml,image/webp"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                        <p class="text-sm text-gray-500 mt-1">Formats acceptés : JPG, JPEG, PNG, SVG, WebP. Taille max : 2MB</p>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                            Mettre à jour le logo
                        </button>
                    </div>
                </form>
            </div>

            <!-- Section Services -->
            <div x-show="activeTab === 'services'" class="mt-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Nos Services</h3>
                    <a href="{{ route('admin.services.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Ajouter un service
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($services as $service)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="font-semibold text-gray-900">{{ $service->title }}</h4>
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.services.edit', $service) }}" class="text-blue-600 hover:text-blue-800 text-sm">Éditer</a>
                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600">{{ Str::limit($service->description, 100) }}</p>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-8">
                            <p class="text-gray-500">Aucun service configuré</p>
                            <a href="{{ route('admin.services.create') }}" class="text-blue-600 hover:text-blue-800">Créer le premier service</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Section Témoignages -->
            <div x-show="activeTab === 'testimonials'" class="mt-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Témoignages Clients</h3>
                    <a href="{{ route('admin.testimonials.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Ajouter un témoignage
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($testimonials as $testimonial)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-start mb-3">
                                @if($testimonial->client_photo)
                                    <img src="{{ asset('storage/' . $testimonial->client_photo) }}" alt="{{ $testimonial->client_name }}" class="w-12 h-12 rounded-full mr-3">
                                @else
                                    <div class="w-12 h-12 bg-gray-300 rounded-full mr-3 flex items-center justify-center">
                                        <span class="text-gray-600 text-lg">{{ substr($testimonial->client_name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <h4 class="font-semibold">{{ $testimonial->client_name }}</h4>
                                    @if($testimonial->client_title)
                                        <p class="text-sm text-gray-600">{{ $testimonial->client_title }}</p>
                                    @endif
                                    <div class="flex items-center mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-gray-700 mb-3">{{ Str::limit($testimonial->testimonial, 150) }}</p>
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                    Modifier
                                </a>
                                <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm" 
                                            onclick="return confirm('Êtes-vous sûr ?')">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-8 text-gray-500">
                            Aucun témoignage configuré. <a href="{{ route('admin.testimonials.create') }}" class="text-blue-600">Ajouter le premier témoignage</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Section Processus -->
            <div x-show="activeTab === 'process'" class="mt-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Comment ça Marche (Processus)</h3>
                    <a href="{{ route('admin.process-steps.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Ajouter une étape
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @forelse($processSteps as $step)
                        <div class="border border-gray-200 rounded-lg p-4 text-center">
                            <div class="w-16 h-16 bg-blue-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                                @if($step->icon)
                                    <img src="{{ asset('storage/' . $step->icon) }}" alt="{{ $step->title }}" class="w-10 h-10">
                                @else
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ $step->order }}
                                    </div>
                                @endif
                            </div>
                            <h4 class="font-semibold mb-2">{{ $step->title }}</h4>
                            <p class="text-sm text-gray-600 mb-4">{{ Str::limit($step->description, 100) }}</p>
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('admin.process-steps.edit', $step) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                    Modifier
                                </a>
                                <form action="{{ route('admin.process-steps.destroy', $step) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm" 
                                            onclick="return confirm('Êtes-vous sûr ?')">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-8 text-gray-500">
                            Aucune étape configurée. <a href="{{ route('admin.process-steps.create') }}" class="text-blue-600">Ajouter la première étape</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Section Partenaires -->
            <div x-show="activeTab === 'partners'" class="mt-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Nos Partenaires</h3>
                    <a href="{{ route('admin.partners.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Ajouter un partenaire
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @forelse($partners as $partner)
                        <div class="border border-gray-200 rounded-lg p-4 text-center">
                            <div class="w-24 h-16 mx-auto mb-4 bg-gray-100 rounded flex items-center justify-center">
                                @if($partner->logo)
                                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="max-w-full max-h-full object-contain">
                                @else
                                    <span class="text-gray-400">{{ substr($partner->name, 0, 2) }}</span>
                                @endif
                            </div>
                            <h4 class="font-semibold mb-2">{{ $partner->name }}</h4>
                            @if($partner->description)
                                <p class="text-sm text-gray-600 mb-2">{{ Str::limit($partner->description, 80) }}</p>
                            @endif
                            @if($partner->website_url)
                                <a href="{{ $partner->website_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm block mb-2">
                                    Visiter le site
                                </a>
                            @endif
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('admin.partners.edit', $partner) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                    Modifier
                                </a>
                                <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm" 
                                            onclick="return confirm('Êtes-vous sûr ?')">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-4 text-center py-8 text-gray-500">
                            Aucun partenaire configuré. <a href="{{ route('admin.partners.create') }}" class="text-blue-600">Ajouter le premier partenaire</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Section CTA -->
            <div x-show="activeTab === 'cta'" class="mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Section Call to Action</h3>
                <form action="{{ route('admin.home-content.update-cta') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Titre</label>
                            <input type="text" name="title" class="w-full px-3 py-2 border border-gray-300 rounded-md" 
                                   value="{{ $cta?->title ?? 'Prêt à Concrétiser Votre Projet ?' }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" class="w-full px-3 py-2 border border-gray-300 rounded-md" rows="3" required>{{ $cta?->description ?? 'Profitez de notre expertise pour acquérir le bien de vos rêves en Afrique du Sud. Consultation gratuite et sans engagement.' }}</textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Texte bouton 1</label>
                                <input type="text" name="button_1_text" class="w-full px-3 py-2 border border-gray-300 rounded-md" 
                                       value="{{ $cta?->button_1_text ?? 'Demander un Accompagnement' }}" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">URL bouton 1</label>
                                <input type="text" name="button_1_url" class="w-full px-3 py-2 border border-gray-300 rounded-md" 
                                       value="{{ $cta?->button_1_url ?? '/accompagnement' }}" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Texte bouton 2</label>
                                <input type="text" name="button_2_text" class="w-full px-3 py-2 border border-gray-300 rounded-md" 
                                       value="{{ $cta?->button_2_text ?? 'Nous Contacter' }}" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">URL bouton 2</label>
                                <input type="text" name="button_2_url" class="w-full px-3 py-2 border border-gray-300 rounded-md" 
                                       value="{{ $cta?->button_2_url ?? '/contact' }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                            Sauvegarder la section CTA
                        </button>
                    </div>
                </form>
            </div>

            <!-- Section Contact -->
            <div x-show="activeTab === 'contact'" class="mt-6" x-data="{ contactTab: 'header' }">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Gestion de la Page Contact</h3>
                
                <!-- Sous-navigation Contact -->
                <div class="border-b border-gray-200 mb-6">
                    <nav class="-mb-px flex space-x-8">
                        <button @click="contactTab = 'header'" 
                                :class="contactTab === 'header' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'"
                                class="py-2 px-1 border-b-2 font-medium text-sm">
                            En-tête
                        </button>
                        <button @click="contactTab = 'form'" 
                                :class="contactTab === 'form' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'"
                                class="py-2 px-1 border-b-2 font-medium text-sm">
                            Formulaire
                        </button>
                        <button @click="contactTab = 'info'" 
                                :class="contactTab === 'info' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'"
                                class="py-2 px-1 border-b-2 font-medium text-sm">
                            Informations
                        </button>
                        <button @click="contactTab = 'why_choose'" 
                                :class="contactTab === 'why_choose' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'"
                                class="py-2 px-1 border-b-2 font-medium text-sm">
                            Pourquoi nous choisir
                        </button>
                        <button @click="contactTab = 'partner'" 
                                :class="contactTab === 'partner' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'"
                                class="py-2 px-1 border-b-2 font-medium text-sm">
                            Partenaire
                        </button>
                    </nav>
                </div>

                <!-- Contact Header -->
                <div x-show="contactTab === 'header'">
                    <form action="{{ route('admin.home-content.update-contact-header') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label for="contact_title" class="block text-sm font-medium text-gray-700">Titre de la page</label>
                                <input type="text" name="title" id="contact_title" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactHeader['title'] ?? 'Contactez-Nous' }}" required>
                            </div>
                            <div>
                                <label for="contact_description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="contact_description" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ $contactHeader['description'] ?? '' }}</textarea>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                                Mettre à jour l'en-tête
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Contact Form -->
                <div x-show="contactTab === 'form'">
                    <form action="{{ route('admin.home-content.update-contact-form') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="form_section_title" class="block text-sm font-medium text-gray-700">Titre de section</label>
                                <input type="text" name="section_title" id="form_section_title" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactForm['section_title'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="form_subtitle" class="block text-sm font-medium text-gray-700">Sous-titre</label>
                                <input type="text" name="subtitle" id="form_subtitle" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactForm['subtitle'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="label_prenom" class="block text-sm font-medium text-gray-700">Label Prénom</label>
                                <input type="text" name="label_prenom" id="label_prenom" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactForm['label_prenom'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="label_nom" class="block text-sm font-medium text-gray-700">Label Nom</label>
                                <input type="text" name="label_nom" id="label_nom" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactForm['label_nom'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="label_email" class="block text-sm font-medium text-gray-700">Label Email</label>
                                <input type="text" name="label_email" id="label_email" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactForm['label_email'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="label_telephone" class="block text-sm font-medium text-gray-700">Label Téléphone</label>
                                <input type="text" name="label_telephone" id="label_telephone" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactForm['label_telephone'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="label_sujet" class="block text-sm font-medium text-gray-700">Label Sujet</label>
                                <input type="text" name="label_sujet" id="label_sujet" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactForm['label_sujet'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="label_message" class="block text-sm font-medium text-gray-700">Label Message</label>
                                <input type="text" name="label_message" id="label_message" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactForm['label_message'] ?? '' }}" required>
                            </div>
                            <div class="md:col-span-2">
                                <label for="button_text" class="block text-sm font-medium text-gray-700">Texte du bouton</label>
                                <input type="text" name="button_text" id="button_text" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactForm['button_text'] ?? '' }}" required>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                                Mettre à jour le formulaire
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Contact Info -->
                <div x-show="contactTab === 'info'">
                    <form action="{{ route('admin.home-content.update-contact-info') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="info_section_title" class="block text-sm font-medium text-gray-700">Titre de section</label>
                                <input type="text" name="section_title" id="info_section_title" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactInfo['section_title'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="address_label" class="block text-sm font-medium text-gray-700">Label Adresse</label>
                                <input type="text" name="address_label" id="address_label" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactInfo['address_label'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="address_line1" class="block text-sm font-medium text-gray-700">Adresse ligne 1</label>
                                <input type="text" name="address_line1" id="address_line1" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactInfo['address_line1'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="address_line2" class="block text-sm font-medium text-gray-700">Adresse ligne 2</label>
                                <input type="text" name="address_line2" id="address_line2" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactInfo['address_line2'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="phone_label" class="block text-sm font-medium text-gray-700">Label Téléphone</label>
                                <input type="text" name="phone_label" id="phone_label" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactInfo['phone_label'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="phone_france" class="block text-sm font-medium text-gray-700">Téléphone France</label>
                                <input type="text" name="phone_france" id="phone_france" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactInfo['phone_france'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="phone_south_africa" class="block text-sm font-medium text-gray-700">Téléphone Afrique du Sud</label>
                                <input type="text" name="phone_south_africa" id="phone_south_africa" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactInfo['phone_south_africa'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="email_label" class="block text-sm font-medium text-gray-700">Label Email</label>
                                <input type="text" name="email_label" id="email_label" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactInfo['email_label'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="email_contact" class="block text-sm font-medium text-gray-700">Email Contact</label>
                                <input type="email" name="email_contact" id="email_contact" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactInfo['email_contact'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="email_rh" class="block text-sm font-medium text-gray-700">Email RH</label>
                                <input type="email" name="email_rh" id="email_rh" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactInfo['email_rh'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="hours_label" class="block text-sm font-medium text-gray-700">Label Horaires</label>
                                <input type="text" name="hours_label" id="hours_label" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactInfo['hours_label'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="hours_weekdays" class="block text-sm font-medium text-gray-700">Horaires semaine</label>
                                <input type="text" name="hours_weekdays" id="hours_weekdays" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactInfo['hours_weekdays'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="hours_saturday" class="block text-sm font-medium text-gray-700">Horaires samedi</label>
                                <input type="text" name="hours_saturday" id="hours_saturday" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactInfo['hours_saturday'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="hours_sunday" class="block text-sm font-medium text-gray-700">Horaires dimanche</label>
                                <input type="text" name="hours_sunday" id="hours_sunday" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactInfo['hours_sunday'] ?? '' }}" required>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                                Mettre à jour les informations
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Why Choose Us -->
                <div x-show="contactTab === 'why_choose'">
                    <form action="{{ route('admin.home-content.update-contact-why-choose') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label for="why_section_title" class="block text-sm font-medium text-gray-700">Titre de section</label>
                                <input type="text" name="section_title" id="why_section_title" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactWhyChoose['section_title'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="advantage_1" class="block text-sm font-medium text-gray-700">Avantage 1</label>
                                <input type="text" name="advantage_1" id="advantage_1" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactWhyChoose['advantage_1'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="advantage_2" class="block text-sm font-medium text-gray-700">Avantage 2</label>
                                <input type="text" name="advantage_2" id="advantage_2" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactWhyChoose['advantage_2'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="advantage_3" class="block text-sm font-medium text-gray-700">Avantage 3</label>
                                <input type="text" name="advantage_3" id="advantage_3" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactWhyChoose['advantage_3'] ?? '' }}" required>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                                Mettre à jour les avantages
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Partner -->
                <div x-show="contactTab === 'partner'">
                    <form action="{{ route('admin.home-content.update-contact-partner') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label for="partner_title" class="block text-sm font-medium text-gray-700">Titre</label>
                                <input type="text" name="title" id="partner_title" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactPartner['title'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="partner_name" class="block text-sm font-medium text-gray-700">Nom du partenaire</label>
                                <input type="text" name="partner_name" id="partner_name" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactPartner['partner_name'] ?? '' }}" required>
                            </div>
                            <div>
                                <label for="partner_description" class="block text-sm font-medium text-gray-700">Description</label>
                                <input type="text" name="description" id="partner_description" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ $contactPartner['description'] ?? '' }}" required>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                                Mettre à jour le partenaire
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Section Footer -->
            <div x-show="activeTab === 'footer'" class="mt-6" x-data="{ footerTab: 'company' }">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Gestion du Footer</h3>
                
                <!-- Sous-navigation Footer -->
                <div class="border-b border-gray-200 mb-6">
                    <nav class="-mb-px flex space-x-8">
                        <button @click="footerTab = 'company'" 
                                :class="footerTab === 'company' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'"
                                class="py-2 px-1 border-b-2 font-medium text-sm">
                            Informations Entreprise
                        </button>
                        <button @click="footerTab = 'contact'" 
                                :class="footerTab === 'contact' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'"
                                class="py-2 px-1 border-b-2 font-medium text-sm">
                            Contact & Horaires
                        </button>
                        <button @click="footerTab = 'legal'" 
                                :class="footerTab === 'legal' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'"
                                class="py-2 px-1 border-b-2 font-medium text-sm">
                            Informations Légales
                        </button>
                    </nav>
                </div>

                <!-- Footer - Informations Entreprise -->
                <div x-show="footerTab === 'company'">
                    <form action="{{ route('admin.home-content.update-footer-company') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nom de l'entreprise</label>
                                <input type="text" name="company_name" 
                                       value="{{ $footerCompany['company_name'] ?? 'Immobilier SA' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea name="company_description" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md" required>{{ $footerCompany['company_description'] ?? 'Votre partenaire de confiance pour investir dans l\'immobilier sud-africain. Expertise, accompagnement personnalisé et financement sécurisé.' }}</textarea>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Badge certification 1</label>
                                <input type="text" name="certification_1" 
                                       value="{{ $footerCompany['certification_1'] ?? 'Certifié & Assuré' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Badge certification 2</label>
                                <input type="text" name="certification_2" 
                                       value="{{ $footerCompany['certification_2'] ?? 'Expert Agréé' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                                Mettre à jour les informations entreprise
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Footer - Contact & Horaires -->
                <div x-show="footerTab === 'contact'">
                    <form action="{{ route('admin.home-content.update-footer-contact') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email de contact</label>
                                <input type="email" name="email" 
                                       value="{{ $footerContact['email'] ?? 'contact@immobilier-sa.com' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone Afrique du Sud</label>
                                <input type="text" name="phone_france" 
                                       value="{{ $footerContact['phone_france'] ?? '+27 65 86 87 861' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone Afrique du Sud</label>
                                <input type="text" name="phone_south_africa" 
                                       value="{{ $footerContact['phone_south_africa'] ?? '+27 65 86 87 861 (Afrique du Sud)' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                                <input type="text" name="address" 
                                       value="{{ $footerContact['address'] ?? 'Bureau  Afrique du Sud - Sur rendez-vous uniquement' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Horaires semaine</label>
                                <input type="text" name="hours_weekdays" 
                                       value="{{ $footerContact['hours_weekdays'] ?? 'Lun - Ven: 9h - 18h' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Horaires samedi</label>
                                <input type="text" name="hours_saturday" 
                                       value="{{ $footerContact['hours_saturday'] ?? 'Sam: 9h - 13h' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Horaires dimanche</label>
                                <input type="text" name="hours_sunday" 
                                       value="{{ $footerContact['hours_sunday'] ?? 'Dim: Sur rendez-vous' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                                Mettre à jour les informations de contact
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Footer - Informations Légales -->
                <div x-show="footerTab === 'legal'">
                    <form action="{{ route('admin.home-content.update-footer-legal') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Année du copyright</label>
                                <input type="text" name="copyright_year" 
                                       value="{{ $footerLegal['copyright_year'] ?? '2024' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nom légal de l'entreprise</label>
                                <input type="text" name="company_legal_name" 
                                       value="{{ $footerLegal['company_legal_name'] ?? 'Immobilier SA. Tous droits réservés.' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nom du partenaire officiel</label>
                                <input type="text" name="partner_name" 
                                       value="{{ $footerLegal['partner_name'] ?? 'Standard Bank' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description du partenaire</label>
                                <input type="text" name="partner_description" 
                                       value="{{ $footerLegal['partner_description'] ?? 'Solutions de financement privilégiées' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                                Mettre à jour les informations légales
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
