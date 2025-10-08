<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class AvatarUploader extends Component
{
    use WithFileUploads;

    public $avatar;

    public $currentAvatar;

    public function mount()
    {
        $this->currentAvatar = Auth::user()->avatar;
    }

    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => 'image|max:2048', // 2MB max
        ]);
    }

    public function updateAvatar()
    {
        $this->validate([
            'avatar' => 'required|image|max:2048',
        ]);

        $user = Auth::user();

        // Supprimer l'ancien avatar s'il existe
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Sauvegarder la nouvelle image
        $path = $this->avatar->store('avatars', 'public');

        // Mettre à jour l'utilisateur
        $user->update(['avatar' => $path]);

        $this->currentAvatar = $path;
        $this->avatar = null;

        session()->flash('status', 'Avatar mis à jour avec succès !');

        // Dispatch l'événement pour notification
        $this->dispatch('avatar-updated');
    }

    public function deleteAvatar()
    {
        $user = Auth::user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);

            $this->currentAvatar = null;
            session()->flash('status', 'Avatar supprimé avec succès !');

            // Dispatch l'événement pour notification
            $this->dispatch('avatar-deleted');
        }
    }

    public function render()
    {
        return view('livewire.profile.update-avatar-form');
    }
}
