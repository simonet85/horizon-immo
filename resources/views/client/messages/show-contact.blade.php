@extends('layouts.admin')

@section('title', 'Message de contact')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Message de contact</h1>
                <a href="{{ route('client.messages.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">
                    Retour à mes messages
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 text-gray-900">
                    <!-- En-tête du message -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $contactMessage->subject }}</h1>
                                <p class="text-gray-600 mt-1">Envoyé le {{ $contactMessage->created_at->format('d/m/Y à H:i') }}</p>
                            </div>
                            <div class="flex flex-col items-end space-y-2">
                                @if($contactMessage->admin_response)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        Répondu le {{ $contactMessage->responded_at->format('d/m/Y à H:i') }}
                                    </span>
                                @elseif($contactMessage->status === 'read')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        Lu
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                        Non lu
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Type de message -->
                    <div class="bg-blue-50 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <p class="text-blue-800 font-medium">Message de contact général</p>
                        </div>
                    </div>

                    <!-- Votre message -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Votre message</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700 whitespace-pre-wrap">{{ $contactMessage->message }}</p>
                        </div>
                    </div>

                    <!-- Réponse de l'équipe (si disponible) -->
                    @if($contactMessage->admin_response)
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Réponse de notre équipe</h3>
                            <div class="bg-green-50 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $contactMessage->admin_response }}</p>
                                <p class="text-sm text-gray-500 mt-3">
                                    Répondu le {{ $contactMessage->responded_at->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="border-t pt-6">
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="text-yellow-800">
                                        Notre équipe traite votre message. Vous recevrez une réponse par email dès que possible.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Informations de contact -->
                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Vos informations de contact</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $contactMessage->full_name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $contactMessage->email }}</p>
                            </div>
                            @if($contactMessage->phone)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $contactMessage->phone }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 border-t pt-6">
                        <div class="flex justify-center">
                            <a href="{{ route('contact') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Envoyer un nouveau message
                            </a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection