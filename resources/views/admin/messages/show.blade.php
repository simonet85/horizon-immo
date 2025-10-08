@extends('layouts.admin')

@section('title', 'Message de ' . $message->name)

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Message de {{ $message->name }}</h1>
            <p class="text-gray-600 mt-1">Détails du message de contact</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.messages.edit', $message) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                Modifier
            </a>
            <a href="{{ route('admin.messages.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">
                Retour
            </a>
        </div>
    </div>
    <!-- Contenu du message -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
                    <!-- Informations du message -->
                    <div class="mb-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nom</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $message->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <a href="mailto:{{ $message->email }}" class="text-blue-600 hover:text-blue-500">
                                        {{ $message->email }}
                                    </a>
                                </dd>
                            </div>
                            @if($message->phone)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Téléphone</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <a href="tel:{{ $message->phone }}" class="text-blue-600 hover:text-blue-500">
                                            {{ $message->phone }}
                                        </a>
                                    </dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date de réception</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $message->created_at->format('d/m/Y à H:i') }}</dd>
                            </div>
                            @if($message->property)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Propriété concernée</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <a href="{{ route('admin.properties.show', $message->property) }}" class="text-blue-600 hover:text-blue-500">
                                            {{ $message->property->title }}
                                        </a>
                                    </dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Statut</dt>
                                <dd class="mt-1">
                                    @if($message->admin_response)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Répondu le {{ $message->responded_at->format('d/m/Y à H:i') }}
                                        </span>
                                    @elseif($message->is_read)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Lu le {{ $message->read_at->format('d/m/Y à H:i') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Non lu
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Sujet -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Sujet</h3>
                        <p class="text-gray-700">{{ $message->subject }}</p>
                    </div>

                    <!-- Message -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Message</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700 whitespace-pre-wrap">{{ $message->message }}</p>
                        </div>
                    </div>

                    <!-- Réponse admin -->
                    @if($message->admin_response)
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Réponse de l'administration</h3>
                            <div class="bg-blue-50 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $message->admin_response }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Formulaire de réponse -->
                    @if(!$message->admin_response)
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Ajouter une réponse</h3>
                            <form action="{{ route('admin.messages.respond', $message) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="admin_response" class="block text-sm font-medium text-gray-700 mb-2">
                                        Votre réponse
                                    </label>
                                    <textarea name="admin_response" 
                                              id="admin_response" 
                                              rows="6" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Tapez votre réponse ici..."></textarea>
                                    @error('admin_response')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Envoyer la réponse
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
        </div>
    </div>
</div>
@endsection
