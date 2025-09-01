@extends('admin.layout')

@section('title', 'Détails de la Propriété')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $property->title }}
        </h2>
        <div class="flex space-x-2">
            <a href="{{ route('admin.properties.edit', $property) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                Modifier
            </a>
            <a href="{{ route('admin.properties.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg">
                Retour à la liste
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Images -->
        <div class="lg:col-span-2">
            @if($property->images)
                @php $images = is_array($property->images) ? $property->images : json_decode($property->images, true); @endphp
                <div class="space-y-4">
                    <!-- Image principale -->
                    <img src="{{ $images[0] }}" alt="{{ $property->title }}" class="w-full h-96 object-cover rounded-lg">
                    
                    <!-- Autres images -->
                    @if(count($images) > 1)
                        <div class="grid grid-cols-3 md:grid-cols-4 gap-2">
                            @foreach(array_slice($images, 1) as $image)
                                <img src="{{ $image }}" alt="{{ $property->title }}" class="h-24 w-full object-cover rounded-lg">
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500">Aucune image disponible</span>
                </div>
            @endif
        </div>

        <!-- Informations -->
        <div class="space-y-6">
            <!-- Prix et statut -->
            <div class="bg-white p-6 rounded-lg border">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $property->formatted_price }}</h3>
                        <p class="text-gray-600">{{ $property->city }}</p>
                    </div>
                    <div class="flex flex-col items-end space-y-2">
                        @if($property->status === 'available')
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                Disponible
                            </span>
                        @elseif($property->status === 'reserved')
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Réservé
                            </span>
                        @else
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                Vendu
                            </span>
                        @endif
                        
                        @if($property->is_featured)
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                ★ Vedette
                            </span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">Type:</span>
                        <span class="text-gray-900 capitalize">{{ $property->type }}</span>
                    </div>
                    @if($property->bedrooms)
                        <div>
                            <span class="font-medium text-gray-700">Chambres:</span>
                            <span class="text-gray-900">{{ $property->bedrooms }}</span>
                        </div>
                    @endif
                    @if($property->bathrooms)
                        <div>
                            <span class="font-medium text-gray-700">Salles de bain:</span>
                            <span class="text-gray-900">{{ $property->bathrooms }}</span>
                        </div>
                    @endif
                    @if($property->surface_area)
                        <div>
                            <span class="font-medium text-gray-700">Surface:</span>
                            <span class="text-gray-900">{{ number_format($property->surface_area, 0) }} m²</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white p-6 rounded-lg border">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Actions</h4>
                <div class="space-y-2">
                    <a href="{{ route('admin.properties.edit', $property) }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg text-center block">
                        Modifier la propriété
                    </a>
                    <form action="{{ route('admin.properties.destroy', $property) }}" method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette propriété ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg">
                            Supprimer la propriété
                        </button>
                    </form>
                </div>
            </div>

            <!-- Métadonnées -->
            <div class="bg-white p-6 rounded-lg border">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Informations</h4>
                <div class="space-y-2 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">Créé le:</span>
                        <span class="text-gray-900">{{ $property->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Modifié le:</span>
                        <span class="text-gray-900">{{ $property->updated_at->format('d/m/Y à H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description complète -->
        <div class="lg:col-span-3">
            <div class="bg-white p-6 rounded-lg border">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Description</h3>
                <div class="prose max-w-none">
                    {!! nl2br(e($property->description)) !!}
                </div>
            </div>
        </div>

        <!-- Adresse -->
        <div class="lg:col-span-3">
            <div class="bg-white p-6 rounded-lg border">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Localisation</h3>
                <p class="text-gray-700">{{ $property->address }}</p>
                <p class="text-gray-600 text-sm mt-1">{{ $property->city }}</p>
            </div>
        </div>
    </div>
@endsection
