@extends('layouts.admin')

@section('title', isset($service) ? 'Modifier le Service' : 'Nouveau Service')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="mb-6">
            <a href="{{ route('admin.home-content.index') }}" class="text-blue-600 hover:text-blue-800">
                ← Retour à la gestion du contenu
            </a>
            <h2 class="text-2xl font-bold text-gray-900 mt-4">
                {{ isset($service) ? 'Modifier le Service' : 'Nouveau Service' }}
            </h2>
        </div>

        <form action="{{ isset($service) ? route('admin.services.update', $service) : route('admin.services.store') }}" method="POST">
            @csrf
            @if(isset($service))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Titre du service <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $service->title ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">
                        Icône (classe CSS) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="icon" 
                           name="icon" 
                           value="{{ old('icon', $service->icon ?? 'fas fa-star') }}"
                           placeholder="ex: fas fa-home, fas fa-search, etc."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('icon') border-red-500 @enderror"
                           required>
                    @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Utilisez les classes FontAwesome (ex: fas fa-home)</p>
                </div>

                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                        Couleur <span class="text-red-500">*</span>
                    </label>
                    <input type="color" 
                           id="color" 
                           name="color" 
                           value="{{ old('color', $service->color ?? '#3B82F6') }}"
                           class="w-full h-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('color') border-red-500 @enderror"
                           required>
                    @error('color')
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
                           value="{{ old('order', $service->order ?? 0) }}"
                           min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('order') border-red-500 @enderror"
                           required>
                    @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                          required>{{ old('description', $service->description ?? '') }}</textarea>
                @error('description')
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
                           {{ old('active', $service->active ?? true) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="active" class="ml-2 block text-sm text-gray-700">
                        Service actif (affiché sur le site)
                    </label>
                </div>
            </div>

            <!-- Aperçu -->
            <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Aperçu :</h3>
                <div class="flex items-center p-4 border border-gray-200 rounded-lg bg-white">
                    <div id="preview-icon" class="w-12 h-12 rounded-full flex items-center justify-center mr-4" style="background-color: {{ old('color', $service->color ?? '#3B82F6') }}20; color: {{ old('color', $service->color ?? '#3B82F6') }}">
                        <i class="{{ old('icon', $service->icon ?? 'fas fa-star') }}"></i>
                    </div>
                    <div>
                        <h4 id="preview-title" class="font-semibold text-gray-900">{{ old('title', $service->title ?? 'Titre du service') }}</h4>
                        <p id="preview-description" class="text-sm text-gray-600">{{ old('description', $service->description ?? 'Description du service...') }}</p>
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
                    {{ isset($service) ? 'Mettre à jour' : 'Créer' }} le service
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Script pour la prévisualisation en temps réel
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const descriptionInput = document.getElementById('description');
    const iconInput = document.getElementById('icon');
    const colorInput = document.getElementById('color');
    
    const previewTitle = document.getElementById('preview-title');
    const previewDescription = document.getElementById('preview-description');
    const previewIcon = document.getElementById('preview-icon');
    
    function updatePreview() {
        previewTitle.textContent = titleInput.value || 'Titre du service';
        previewDescription.textContent = descriptionInput.value || 'Description du service...';
        
        // Mettre à jour l'icône
        previewIcon.innerHTML = '<i class="' + (iconInput.value || 'fas fa-star') + '"></i>';
        
        // Mettre à jour la couleur
        const color = colorInput.value || '#3B82F6';
        previewIcon.style.backgroundColor = color + '20';
        previewIcon.style.color = color;
    }
    
    titleInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);
    iconInput.addEventListener('input', updatePreview);
    colorInput.addEventListener('change', updatePreview);
});
</script>

<!-- Inclure FontAwesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
