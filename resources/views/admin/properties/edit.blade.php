@extends('layouts.admin')

@section('title', 'Modifier la Propriété')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Modifier la Propriété</h1>
            <p class="text-gray-600 mt-1">{{ $property->title }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.properties.show', $property) }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Voir
            </a>
            <a href="{{ route('admin.properties.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour à la liste
            </a>
        </div>
    </div>

    <!-- Formulaire -->
    <form action="{{ route('admin.properties.update', $property) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Titre -->
            <div class="md:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-700">Titre *</label>
                <input type="text" name="title" id="title" value="{{ old('title', $property->title) }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catégorie -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Catégorie *</label>
                <select name="category_id" id="category_id" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('category_id') border-red-500 @enderror">
                    <option value="">Sélectionner une catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $property->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ville -->
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700">Ville *</label>
                <select name="city" id="city" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('city') border-red-500 @enderror">
                    <option value="">Sélectionner une ville</option>
                    <option value="Cape Town" {{ old('city', $property->city) === 'Cape Town' ? 'selected' : '' }}>Le Cap</option>
                    <option value="Johannesburg" {{ old('city', $property->city) === 'Johannesburg' ? 'selected' : '' }}>Johannesburg</option>
                    <option value="Durban" {{ old('city', $property->city) === 'Durban' ? 'selected' : '' }}>Durban</option>
                    <option value="Pretoria" {{ old('city', $property->city) === 'Pretoria' ? 'selected' : '' }}>Pretoria</option>
                    <option value="Port Elizabeth" {{ old('city', $property->city) === 'Port Elizabeth' ? 'selected' : '' }}>Port Elizabeth</option>
                    <option value="Stellenbosch" {{ old('city', $property->city) === 'Stellenbosch' ? 'selected' : '' }}>Stellenbosch</option>
                    <option value="Franschhoek" {{ old('city', $property->city) === 'Franschhoek' ? 'selected' : '' }}>Franschhoek</option>
                    <option value="Hermanus" {{ old('city', $property->city) === 'Hermanus' ? 'selected' : '' }}>Hermanus</option>
                </select>
                @error('city')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Prix -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Prix (FCFA) *</label>
                <input type="number" name="price" id="price" value="{{ old('price', $property->price) }}" step="0.01" min="0"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('price') border-red-500 @enderror">
                @error('price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type de transaction -->
            <div>
                <label for="transaction_type" class="block text-sm font-medium text-gray-700">Type de transaction</label>
                <select name="transaction_type" id="transaction_type"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('transaction_type') border-red-500 @enderror">
                    <option value="Vente" {{ old('transaction_type', $property->transaction_type) === 'Vente' ? 'selected' : '' }}>Vente</option>
                    <option value="Location" {{ old('transaction_type', $property->transaction_type) === 'Location' ? 'selected' : '' }}>Location</option>
                </select>
                @error('transaction_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Statut -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Statut *</label>
                <select name="status" id="status"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                    <option value="available" {{ old('status', $property->status) === 'available' ? 'selected' : '' }}>Disponible</option>
                    <option value="reserved" {{ old('status', $property->status) === 'reserved' ? 'selected' : '' }}>Réservé</option>
                    <option value="sold" {{ old('status', $property->status) === 'sold' ? 'selected' : '' }}>Vendu</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Adresse -->
            <div class="md:col-span-2">
                <label for="address" class="block text-sm font-medium text-gray-700">Adresse *</label>
                <textarea name="address" id="address" rows="2" 
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('address') border-red-500 @enderror">{{ old('address', $property->address) }}</textarea>
                @error('address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Chambres -->
            <div>
                <label for="bedrooms" class="block text-sm font-medium text-gray-700">Chambres</label>
                <input type="number" name="bedrooms" id="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" min="0"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('bedrooms') border-red-500 @enderror">
                @error('bedrooms')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Salles de bain -->
            <div>
                <label for="bathrooms" class="block text-sm font-medium text-gray-700">Salles de bain</label>
                <input type="number" name="bathrooms" id="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" min="0"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('bathrooms') border-red-500 @enderror">
                @error('bathrooms')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Surface -->
            <div>
                <label for="surface_area" class="block text-sm font-medium text-gray-700">Surface (m²)</label>
                <input type="number" name="surface_area" id="surface_area" value="{{ old('surface_area', $property->surface_area) }}" step="0.01" min="0"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('surface_area') border-red-500 @enderror">
                @error('surface_area')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Propriété vedette -->
            <div class="flex items-center">
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $property->is_featured) ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                    Propriété vedette
                </label>
            </div>

            <!-- Images actuelles -->
            @if($property->images)
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Images actuelles</label>
                    <div class="mt-2 grid grid-cols-3 md:grid-cols-6 gap-2">
                        @foreach(is_array($property->images) ? $property->images : json_decode($property->images, true) as $image)
                            <img src="{{ $image }}" alt="Image de la propriété" class="h-20 w-20 object-cover rounded-lg">
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Nouvelles images -->
            <div class="md:col-span-2">
                <label for="images" class="block text-sm font-medium text-gray-700">Nouvelles images (optionnel)</label>
                <input type="file" name="images[]" id="images" multiple accept="image/*"
                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="mt-1 text-sm text-gray-500">Les nouvelles images remplaceront les images actuelles si vous en sélectionnez.</p>
                @error('images')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('images.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                <textarea name="description" id="description" rows="4" 
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $property->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.properties.show', $property) }}" 
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg">
                Annuler
            </a>
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                Mettre à jour
            </button>
        </div>
    </form>
@endsection
