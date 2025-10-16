@extends('layouts.admin')

@section('title', 'Modifier la catégorie')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Modifier la catégorie</h1>
            <a href="{{ route('admin.categories.show', $category) }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Retour
            </a>
        </div>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Informations principales -->
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Nom de la catégorie <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $category->name) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-300 @enderror"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700">
                            Slug <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="slug" 
                               id="slug" 
                               value="{{ old('slug', $category->slug) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('slug') border-red-300 @enderror"
                               required>
                        <p class="mt-1 text-sm text-gray-500">
                            Le slug sera généré automatiquement à partir du nom si laissé vide.
                        </p>
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Description
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-300 @enderror"
                                  placeholder="Description de la catégorie...">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   id="is_active" 
                                   value="1"
                                   {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                Catégorie active
                            </label>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            Seules les catégories actives sont visibles sur le site.
                        </p>
                        @error('is_active')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Statistiques et informations -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Statistiques</h3>
                    
                    <div class="space-y-4">
                        <div class="bg-white p-3 rounded border">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-600">Propriétés associées</span>
                                <span class="text-lg font-bold text-indigo-600">{{ $category->properties->count() }}</span>
                            </div>
                        </div>

                        <div class="bg-white p-3 rounded border">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-600">Date de création</span>
                                <span class="text-sm text-gray-900">{{ $category->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>

                        <div class="bg-white p-3 rounded border">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-600">Dernière modification</span>
                                <span class="text-sm text-gray-900">{{ $category->updated_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>

                    @if($category->properties->count() > 0)
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Dernières propriétés</h4>
                        <div class="space-y-2">
                            @foreach($category->properties->take(3) as $property)
                            <div class="bg-white p-2 rounded border text-xs">
                                <div class="font-medium text-gray-900">{{ Str::limit($property->title, 30) }}</div>
                                <div class="text-gray-500">{{ number_format($property->price, 0, ',', ' ') }} €</div>
                            </div>
                            @endforeach
                            @if($category->properties->count() > 3)
                            <p class="text-xs text-gray-500 text-center">
                                et {{ $category->properties->count() - 3 }} autre(s)...
                            </p>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <div class="flex space-x-3">
                    <button type="submit"
                            class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Enregistrer
                    </button>

                    <a href="{{ route('admin.categories.show', $category) }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Annuler
                    </a>
                </div>
            </div>
        </form>

        <!-- Formulaire de suppression séparé -->
        <div class="flex justify-end mt-4 pt-4 border-t border-gray-200">
            <form action="{{ route('admin.categories.destroy', $category) }}"
                  method="POST"
                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ? Cette action est irréversible.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        {{ $category->properties->count() > 0 ? 'disabled title=Cette catégorie contient des propriétés et ne peut pas être supprimée' : '' }}>
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Supprimer
                </button>
            </form>
        </div>
    </div>
</div>

<script>
// Générer automatiquement le slug à partir du nom
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const slug = name.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '') // Supprime les caractères spéciaux
                    .replace(/\s+/g, '-')          // Remplace les espaces par des tirets
                    .replace(/-+/g, '-')           // Supprime les tirets multiples
                    .trim();
    document.getElementById('slug').value = slug;
});
</script>
@endsection
