<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateAvatarForm extends Component
{
    use WithFileUploads;

    public $avatar;

    public $temporaryUrl;

    public function rules(): array
    {
        return [
            'avatar' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048', // 2MB max
            ],
        ];
    }

    public function updatedAvatar(): void
    {
        // Si aucun fichier sélectionné, reset
        if (!$this->avatar) {
            $this->temporaryUrl = null;
            return;
        }

        $this->validate();

        if ($this->avatar) {
            $this->temporaryUrl = $this->avatar->temporaryUrl();
        }
    }

    public function updateAvatar(): void
    {
        $this->validate();

        $user = Auth::user();

        // Supprimer l'ancien avatar s'il existe
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Stocker le nouvel avatar
        $path = $this->avatar->store('avatars', 'public');

        // Mettre à jour l'utilisateur
        $user->update(['avatar' => $path]);

        // Reset du formulaire
        $this->reset(['avatar', 'temporaryUrl']);

        // Émettre un événement pour rafraîchir l'interface
        $this->dispatch('avatar-updated');

        session()->flash('success', 'Avatar mis à jour avec succès !');
    }

    public function deleteAvatar(): void
    {
        $user = Auth::user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);

            $this->dispatch('avatar-updated');
            session()->flash('success', 'Avatar supprimé avec succès !');
        }
    }

    public function cancelSelection(): void
    {
        $this->reset(['avatar', 'temporaryUrl']);
        session()->flash('info', 'Sélection annulée.');
    }

    public function getUserInitials(): string
    {
        $user = Auth::user();
        if (! $user) {
            return 'U';
        }

        $name = trim($user->name);
        if (empty($name)) {
            return 'U';
        }

        // Séparer par espaces et tirets
        $nameParts = preg_split('/[\s\-]+/', $name);
        $initials = '';
        foreach ($nameParts as $part) {
            $part = trim($part);
            if (! empty($part)) {
                $initials .= strtoupper(substr($part, 0, 1));
            }
        }

        return empty($initials) ? 'U' : $initials;
    }

    public function render()
    {
        return view('livewire.forms.update-avatar-form');
    }
}
