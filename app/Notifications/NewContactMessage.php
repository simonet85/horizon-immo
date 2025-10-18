<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactMessage extends Notification implements ShouldQueue
{
    use Queueable;

    public $contactMessage;

    /**
     * Create a new notification instance.
     */
    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouveau message de contact - ZB Investments')
            ->bcc(config('mail.from.address')) // Copie vers l'email professionnel
            ->greeting('Bonjour !')
            ->line('Un nouveau message de contact a été reçu sur le site ZB Investments.')
            ->line('**Détails du message :**')
            ->line('**De :** '.$this->contactMessage->full_name)
            ->line('**Email :** '.$this->contactMessage->email)
            ->line('**Téléphone :** '.($this->contactMessage->phone ?: 'Non renseigné'))
            ->line('**Sujet :** '.$this->contactMessage->subject)
            ->line('**Message :**')
            ->line($this->contactMessage->message)
            ->action('Voir dans l\'admin', url('/admin/contact-messages/'.$this->contactMessage->id))
            ->line('Vous pouvez répondre directement à ce message en contactant le client.')
            ->salutation('Cordialement, L\'équipe ZB Investments');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'contact_message_id' => $this->contactMessage->id,
            'sender_name' => $this->contactMessage->full_name,
            'sender_email' => $this->contactMessage->email,
            'subject' => $this->contactMessage->subject,
            'message_preview' => substr($this->contactMessage->message, 0, 100).'...',
        ];
    }
}
