@extends('admin.layout')

@section('title', 'Modifier la Propriété')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier : {{ $property->title }}
        </h2>
        <div class="flex space-x-2">
            <a href="{{ route('admin.properties.show', $property) }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg">
                Voir
            </a>
            <a href="{{ route('admin.properties.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg">
                Retour à la liste
            </a>
        </div>
    </div>
@endsection

@section('content')
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

            <!-- Type -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">Type *</label>
                <select name="type" id="type" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('type') border-red-500 @enderror">
                    <option value="">Sélectionner un type</option>
                    <option value="villa" {{ old('type', $property->type) === 'villa' ? 'selected' : '' }}>Villa</option>
                    <option value="maison" {{ old('type', $property->type) === 'maison' ? 'selected' : '' }}>Maison</option>
                    <option value="appartement" {{ old('type', $property->type) === 'appartement' ? 'selected' : '' }}>Appartement</option>
                    <option value="terrain" {{ old('type', $property->type) === 'terrain' ? 'selected' : '' }}>Terrain</option>
                    <option value="commercial" {{ old('type', $property->type) === 'commercial' ? 'selected' : '' }}>Commercial</option>
                </select>
                @error('type')
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
                <label for="price" class="block text-sm font-medium text-gray-700">Prix (ZAR) *</label>
                <input type="number" name="price" id="price" value="{{ old('price', $property->price) }}" step="0.01" min="0"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('price') border-red-500 @enderror">
                @error('price')
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
