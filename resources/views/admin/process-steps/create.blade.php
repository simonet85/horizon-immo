@extends('layouts.admin')

@section('title', isset($processStep) ? 'Modifier l\'Étape' : 'Nouvelle Étape')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="mb-6">
            <a href="{{ route('admin.home-content.index') }}" class="text-blue-600 hover:text-blue-800">
                ← Retour à la gestion du contenu
            </a>
            <h2 class="text-2xl font-bold text-gray-900 mt-4">
                {{ isset($processStep) ? 'Modifier l\'Étape de Processus' : 'Nouvelle Étape de Processus' }}
            </h2>
        </div>

        <form action="{{ isset($processStep) ? route('admin.process-steps.update', $processStep) : route('admin.process-steps.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($processStep))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Titre <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $processStep->title ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('title')
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
                           value="{{ old('order', $processStep->order ?? 0) }}"
                           min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">
                        Icône
                    </label>
                    <input type="file" 
                           id="icon" 
                           name="icon" 
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if(isset($processStep) && $processStep->icon)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $processStep->icon) }}" alt="Icône actuelle" class="w-16 h-16 object-cover">
                            <p class="text-xs text-gray-500 mt-1">Icône actuelle</p>
                        </div>
                    @endif
                    <p class="text-xs text-gray-500 mt-1">
                        Formats acceptés: JPG, PNG, GIF, SVG. Taille recommandée: 64x64px
                    </p>
                </div>
            </div>

            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          required>{{ old('description', $processStep->description ?? '') }}</textarea>
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
                           {{ old('active', $processStep->active ?? true) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="active" class="ml-2 block text-sm text-gray-700">
                        Étape active (affichée sur le site)
                    </label>
                </div>
            </div>

            <!-- Aperçu -->
            <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Aperçu :</h3>
                <div class="flex flex-col items-center text-center p-6 border border-gray-200 rounded-lg bg-white">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h4 id="preview-title" class="text-lg font-semibold text-gray-900 mb-2">{{ old('title', $processStep->title ?? 'Titre de l\'étape') }}</h4>
                    <p id="preview-description" class="text-sm text-gray-600">{{ old('description', $processStep->description ?? 'La description de l\'étape apparaîtra ici...') }}</p>
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('admin.home-content.index') }}" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    {{ isset($processStep) ? 'Mettre à jour' : 'Créer' }} l'étape
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
    
    const previewTitle = document.getElementById('preview-title');
    const previewDescription = document.getElementById('preview-description');
    
    function updatePreview() {
        previewTitle.textContent = titleInput.value || 'Titre de l\'étape';
        previewDescription.textContent = descriptionInput.value || 'La description de l\'étape apparaîtra ici...';
    }
    
    titleInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);
});
</script>
@endsection
