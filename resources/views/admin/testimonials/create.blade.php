@extends('layouts.admin')

@section('title', isset($testimonial) ? 'Modifier le Témoignage' : 'Nouveau Témoignage')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="mb-6">
            <a href="{{ route('admin.home-content.index') }}" class="text-blue-600 hover:text-blue-800">
                ← Retour à la gestion du contenu
            </a>
            <h2 class="text-2xl font-bold text-gray-900 mt-4">
                {{ isset($testimonial) ? 'Modifier le Témoignage' : 'Nouveau Témoignage' }}
            </h2>
        </div>

        <form action="{{ isset($testimonial) ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($testimonial))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="client_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom du client <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="client_name" 
                           name="client_name" 
                           value="{{ old('client_name', $testimonial->client_name ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('client_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="client_title" class="block text-sm font-medium text-gray-700 mb-2">
                        Titre/Profession du client
                    </label>
                    <input type="text" 
                           id="client_title" 
                           name="client_title" 
                           value="{{ old('client_title', $testimonial->client_title ?? '') }}"
                           placeholder="ex: Chef d'entreprise, Investisseur..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('client_title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="rating" class="block text-sm font-medium text-gray-700 mb-2">
                        Note <span class="text-red-500">*</span>
                    </label>
                    <select id="rating" 
                            name="rating" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('rating', $testimonial->rating ?? 5) == $i ? 'selected' : '' }}>
                                {{ $i }} étoile{{ $i > 1 ? 's' : '' }}
                            </option>
                        @endfor
                    </select>
                    @error('rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="property_type" class="block text-sm font-medium text-gray-700 mb-2">
                        Type de bien acquis
                    </label>
                    <input type="text" 
                           id="property_type" 
                           name="property_type" 
                           value="{{ old('property_type', $testimonial->property_type ?? '') }}"
                           placeholder="ex: Villa, Appartement, Maison..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('property_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                        Ordre d'affichage <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="order" 
                           name="order" 
                           value="{{ old('order', $testimonial->order ?? 0) }}"
                           min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="client_photo" class="block text-sm font-medium text-gray-700 mb-2">
                        Photo du client
                    </label>
                    <input type="file" 
                           id="client_photo" 
                           name="client_photo" 
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('client_photo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if(isset($testimonial) && $testimonial->client_photo)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $testimonial->client_photo) }}" alt="Photo actuelle" class="w-16 h-16 rounded-full object-cover">
                            <p class="text-xs text-gray-500 mt-1">Photo actuelle</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6">
                <label for="testimonial" class="block text-sm font-medium text-gray-700 mb-2">
                    Témoignage <span class="text-red-500">*</span>
                </label>
                <textarea id="testimonial" 
                          name="testimonial" 
                          rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          required>{{ old('testimonial', $testimonial->testimonial ?? '') }}</textarea>
                @error('testimonial')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <div class="flex items-center">
                    <input type="hidden" name="active" value="0">
                    <input type="checkbox" 
                           id="active" 
                           name="active" 
                           value="1"
                           {{ old('active', $testimonial->active ?? true) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="active" class="ml-2 block text-sm text-gray-700">
                        Témoignage actif (affiché sur le site)
                    </label>
                </div>
            </div>

            <!-- Aperçu -->
            <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Aperçu :</h3>
                <div class="flex items-start p-4 border border-gray-200 rounded-lg bg-white">
                    <div class="w-12 h-12 bg-gray-300 rounded-full mr-4 flex items-center justify-center">
                        <span id="preview-initial" class="text-gray-600 text-lg">{{ substr(old('client_name', $testimonial->client_name ?? 'C'), 0, 1) }}</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <div>
                                <h4 id="preview-name" class="font-semibold text-gray-900">{{ old('client_name', $testimonial->client_name ?? 'Nom du client') }}</h4>
                                <p id="preview-title" class="text-sm text-gray-600">{{ old('client_title', $testimonial->client_title ?? '') }}</p>
                            </div>
                            <div id="preview-stars" class="ml-auto flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 star {{ $i <= (old('rating', $testimonial->rating ?? 5)) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                        <p id="preview-testimonial" class="text-sm text-gray-700">{{ old('testimonial', $testimonial->testimonial ?? 'Le témoignage apparaîtra ici...') }}</p>
                        <p id="preview-property" class="text-xs text-gray-500 mt-2">Type de bien : {{ old('property_type', $testimonial->property_type ?? 'Non spécifié') }}</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('admin.home-content.index') }}" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    {{ isset($testimonial) ? 'Mettre à jour' : 'Créer' }} le témoignage
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Script pour la prévisualisation en temps réel
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('client_name');
    const titleInput = document.getElementById('client_title');
    const testimonialInput = document.getElementById('testimonial');
    const ratingInput = document.getElementById('rating');
    const propertyInput = document.getElementById('property_type');
    
    const previewName = document.getElementById('preview-name');
    const previewTitle = document.getElementById('preview-title');
    const previewTestimonial = document.getElementById('preview-testimonial');
    const previewProperty = document.getElementById('preview-property');
    const previewInitial = document.getElementById('preview-initial');
    const previewStars = document.getElementById('preview-stars');
    
    function updatePreview() {
        previewName.textContent = nameInput.value || 'Nom du client';
        previewTitle.textContent = titleInput.value || '';
        previewTestimonial.textContent = testimonialInput.value || 'Le témoignage apparaîtra ici...';
        previewProperty.textContent = 'Type de bien : ' + (propertyInput.value || 'Non spécifié');
        previewInitial.textContent = (nameInput.value || 'C').charAt(0).toUpperCase();
        
        // Mettre à jour les étoiles
        const rating = parseInt(ratingInput.value) || 5;
        const stars = previewStars.querySelectorAll('.star');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-400');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        });
    }
    
    nameInput.addEventListener('input', updatePreview);
    titleInput.addEventListener('input', updatePreview);
    testimonialInput.addEventListener('input', updatePreview);
    ratingInput.addEventListener('change', updatePreview);
    propertyInput.addEventListener('input', updatePreview);
});
</script>
@endsection
