<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPropertyMessage extends Notification implements ShouldQueue
{
    use Queueable;

    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
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
            ->subject('Nouvelle question sur une propriété - Horizon Immo')
            ->greeting('Bonjour !')
            ->line('Une nouvelle question a été reçue concernant une propriété.')
            ->line('**Détails de la question :**')
            ->line('**Propriété :** '.$this->message->property->title)
            ->line('**Prix :** '.$this->message->property->formatted_price)
            ->line('**Ville :** '.$this->message->property->city)
            ->line('')
            ->line('**De :** '.$this->message->name)
            ->line('**Email :** '.$this->message->email)
            ->line('**Téléphone :** '.($this->message->phone ?: 'Non renseigné'))
            ->line('**Sujet :** '.$this->message->subject)
            ->line('**Question :**')
            ->line($this->message->message)
            ->action('Voir dans l\'admin', url('/admin/messages/'.$this->message->id))
            ->line('Vous pouvez répondre directement à cette question en contactant le client.')
            ->salutation('Cordialement, L\'équipe Horizon Immo');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message_id' => $this->message->id,
            'property_id' => $this->message->property_id,
            'property_title' => $this->message->property->title,
            'sender_name' => $this->message->name,
            'sender_email' => $this->message->email,
            'subject' => $this->message->subject,
            'message_preview' => substr($this->message->message, 0, 100).'...',
        ];
    }
}
