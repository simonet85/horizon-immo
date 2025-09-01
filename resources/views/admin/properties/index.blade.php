@extends('admin.layout')

@section('title', 'Gestion des Propriétés')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestion des Propriétés
        </h2>
        <a href="{{ route('admin.properties.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
            Ajouter une Propriété
        </a>
    </div>
@endsection

@section('content')
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ville</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vedette</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($properties as $property)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ $property->main_image }}" alt="{{ $property->title }}" class="h-16 w-16 object-cover rounded-lg">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ Str::limit($property->title, 30) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $property->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $property->city }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $property->formatted_price }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($property->status === 'available')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Disponible
                                </span>
                            @elseif($property->status === 'reserved')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Réservé
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Vendu
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($property->is_featured)
                                <span class="text-yellow-500">★</span>
                            @else
                                <span class="text-gray-300">☆</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.properties.show', $property) }}" class="text-blue-600 hover:text-blue-900">Voir</a>
                                <a href="{{ route('admin.properties.edit', $property) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                <form action="{{ route('admin.properties.destroy', $property) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette propriété ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                            Aucune propriété trouvée.
                            <a href="{{ route('admin.properties.create') }}" class="text-blue-600 hover:text-blue-800 ml-1">
                                Ajouter la première propriété
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($properties->hasPages())
        <div class="mt-6">
            {{ $properties->links() }}
        </div>
    @endif
@endsection
