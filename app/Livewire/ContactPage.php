<?php

namespace App\Livewire;

use App\Models\ContactContent;
use App\Models\ContactMessage;
use App\Models\Message;
use App\Models\Property;
use App\Models\User;
use App\Notifications\ContactMessageReceived;
use App\Notifications\NewContactMessage;
use App\Notifications\NewPropertyMessage;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class ContactPage extends Component
{
    public $first_name = '';

    public $last_name = '';

    public $email = '';

    public $phone = '';

    public $subject = '';

    public $message = '';

    public $showSuccess = false;

    // Nouvelle propriété pour gérer la propriété liée
    public $property_id = null;

    public $property = null;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|min:10',
    ];

    protected $messages = [
        'first_name.required' => 'Le prénom est requis',
        'last_name.required' => 'Le nom est requis',
        'email.required' => 'L\'email est requis',
        'email.email' => 'L\'email doit être valide',
        'phone.required' => 'Le téléphone est requis',
        'subject.required' => 'Le sujet est requis',
        'message.required' => 'Le message est requis',
        'message.min' => 'Le message doit contenir au moins 10 caractères',
    ];

    public function mount()
    {
        // Vérifier si une propriété est spécifiée dans l'URL
        $this->property_id = request()->get('property');

        if ($this->property_id) {
            $this->property = Property::find($this->property_id);

            // Pré-remplir le sujet si une propriété est trouvée
            if ($this->property) {
                $this->subject = 'Question concernant : '.$this->property->title;
            }
        }
    }

    public function sendMessage()
    {
        $this->validate();

        // Si une propriété est spécifiée, créer un Message lié à la propriété
        if ($this->property_id && $this->property) {
            $message = Message::create([
                'name' => $this->first_name.' '.$this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'subject' => $this->subject,
                'message' => $this->message,
                'property_id' => $this->property_id,
                'is_read' => false,
            ]);

            // Envoyer notification aux administrateurs
            $admins = User::role('admin')->get();
            Notification::send($admins, new NewPropertyMessage($message));

            // Envoyer confirmation à l'utilisateur
            Notification::route('mail', $this->email)
                ->notify(new ContactMessageReceived($message, true));
        } else {
            // Sinon, créer un ContactMessage classique
            $contactMessage = ContactMessage::create([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'subject' => $this->subject,
                'message' => $this->message,
            ]);

            // Envoyer notification aux administrateurs
            $admins = User::role('admin')->get();
            Notification::send($admins, new NewContactMessage($contactMessage));

            // Envoyer confirmation à l'utilisateur
            Notification::route('mail', $this->email)
                ->notify(new ContactMessageReceived($contactMessage, false));
        }

        $this->reset(['first_name', 'last_name', 'email', 'phone', 'subject', 'message']);
        $this->showSuccess = true;

        // Auto-hide success message after 5 seconds
        $this->dispatch('hideSuccess');
    }

    public function render()
    {
        // Récupérer le contenu de contact
        $contactHeader = ContactContent::getBySection('header');
        $contactForm = ContactContent::getBySection('form');
        $contactInfo = ContactContent::getBySection('contact_info');
        $contactWhyChoose = ContactContent::getBySection('why_choose');
        $contactPartner = ContactContent::getBySection('partner');

        return view('livewire.contact-page', [
            'property' => $this->property,
            'contactHeader' => $contactHeader,
            'contactForm' => $contactForm,
            'contactInfo' => $contactInfo,
            'contactWhyChoose' => $contactWhyChoose,
            'contactPartner' => $contactPartner,
        ])->layout('layouts.site');
    }
}
