@extends('layouts.admin')

@section('title', 'Messages de Contact')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Messages de Contact</h1>
                <p class="text-gray-600 mt-1">Gérer les messages reçus via le formulaire de contact</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-500">
                    {{ $messages->total() }} messages au total
                </span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filtres et actions -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('admin.contact-messages.bulk-action') }}" id="bulkForm">
            @csrf
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <select name="action" class="rounded-lg border-gray-300 text-sm">
                        <option value="">Action groupée</option>
                        <option value="mark_read">Marquer comme lu</option>
                        <option value="mark_unread">Marquer comme non lu</option>
                        <option value="delete">Supprimer</option>
                    </select>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                        Appliquer
                    </button>
                </div>
                <div class="flex items-center space-x-2">
                    <label class="flex items-center">
                        <input type="checkbox" id="selectAll" class="rounded border-gray-300">
                        <span class="ml-2 text-sm text-gray-600">Tout sélectionner</span>
                    </label>
                </div>
            </div>

            <!-- Liste des messages -->
            <div class="space-y-3">
                @forelse($messages as $message)
                    <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <input type="checkbox" name="messages[]" value="{{ $message->id }}" 
                               class="mt-1 rounded border-gray-300 message-checkbox">
                        
                        <div class="ml-4 flex-1">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <h3 class="font-medium text-gray-900">
                                        {{ $message->full_name }}
                                    </h3>
                                    @if($message->status === 'unread')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Non lu
                                        </span>
                                    @endif
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-500">
                                        {{ $message->created_at->diffForHumans() }}
                                    </span>
                                    <div class="flex items-center space-x-1">
                                        <a href="{{ route('admin.contact-messages.show', $message) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-sm">
                                            Voir
                                        </a>
                                        @if($message->status === 'unread')
                                            <form method="POST" action="{{ route('admin.contact-messages.mark-read', $message) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-800 text-sm">
                                                    Marquer lu
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.contact-messages.mark-unread', $message) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-yellow-600 hover:text-yellow-800 text-sm">
                                                    Non lu
                                                </button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('admin.contact-messages.destroy', $message) }}" 
                                              class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-1">
                                <p class="text-sm text-gray-600">
                                    <strong>Email:</strong> {{ $message->email }}
                                    @if($message->phone)
                                        | <strong>Téléphone:</strong> {{ $message->phone }}
                                    @endif
                                </p>
                                <p class="text-sm text-gray-600 mt-1">
                                    <strong>Sujet:</strong> {{ $message->subject }}
                                </p>
                                <p class="text-gray-700 mt-2">
                                    {{ Str::limit($message->message, 150) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <p class="mt-4">Aucun message de contact trouvé</p>
                    </div>
                @endforelse
            </div>
        </form>

        <!-- Pagination -->
        @if($messages->hasPages())
            <div class="mt-6 border-t pt-4">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.message-checkbox');
    const bulkForm = document.getElementById('bulkForm');

    // Sélectionner/désélectionner tout
    selectAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Vérifier si toutes les cases sont cochées
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            const someChecked = Array.from(checkboxes).some(cb => cb.checked);
            selectAll.checked = allChecked;
            selectAll.indeterminate = !allChecked && someChecked;
        });
    });

    // Validation du formulaire
    bulkForm.addEventListener('submit', function(e) {
        const action = this.querySelector('select[name="action"]').value;
        const selectedMessages = Array.from(checkboxes).filter(cb => cb.checked);

        if (!action) {
            e.preventDefault();
            alert('Veuillez sélectionner une action');
            return;
        }

        if (selectedMessages.length === 0) {
            e.preventDefault();
            alert('Veuillez sélectionner au moins un message');
            return;
        }

        if (action === 'delete') {
            if (!confirm('Êtes-vous sûr de vouloir supprimer les messages sélectionnés ?')) {
                e.preventDefault();
            }
        }
    });
});
</script>
@endpush
@endsection
