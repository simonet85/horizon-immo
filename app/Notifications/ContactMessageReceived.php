<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactMessageReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public $contactMessage;

    public $propertyMessage;

    public $isPropertyMessage;

    /**
     * Create a new notification instance.
     */
    public function __construct($message = null, $isPropertyMessage = false)
    {
        $this->isPropertyMessage = $isPropertyMessage;
        if ($isPropertyMessage) {
            $this->propertyMessage = $message;
        } else {
            $this->contactMessage = $message;
        }
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
        $mailMessage = new MailMessage;

        if ($this->isPropertyMessage) {
            return $mailMessage
                ->subject('Confirmation de votre question - Horizon Immo')
                ->greeting('Bonjour '.$this->propertyMessage->name.' !')
                ->line('Nous avons bien reçu votre question concernant la propriété :')
                ->line('**'.$this->propertyMessage->property->title.'**')
                ->line('Prix : '.$this->propertyMessage->property->formatted_price)
                ->line('Ville : '.$this->propertyMessage->property->city)
                ->line('')
                ->line('Votre question : "'.$this->propertyMessage->subject.'"')
                ->line('Notre équipe va examiner votre demande et vous répondra dans les plus brefs délais.')
                ->action('Voir la propriété', url('/propriete/'.$this->propertyMessage->property_id))
                ->line('Vous pouvez également nous contacter directement :')
                ->line('📧 Email : info@zbinvestments-ci.com')
                ->line('📞 Téléphone : +27 65 86 87 861')
                ->salutation('Cordialement, L\'équipe zb investments');
        } else {
            return $mailMessage
                ->subject('Confirmation de votre message - ZB Investments')
                ->greeting('Bonjour '.$this->contactMessage->full_name.' !')
                ->line('Nous avons bien reçu votre message concernant : "'.$this->contactMessage->subject.'"')
                ->line('Notre équipe va examiner votre demande et vous répondra dans les plus brefs délais.')
                ->action('Découvrir nos propriétés', url('/catalogue'))
                ->line('Vous pouvez également nous contacter directement :')
                ->line('📧 Email : info@zbinvestments-ci.com')
                ->line('📞 Téléphone : +27 65 86 87 861')
                ->salutation('Cordialement, L\'équipe zb investments');
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        if ($this->isPropertyMessage) {
            return [
                'type' => 'property_message_received',
                'property_title' => $this->propertyMessage->property->title,
                'subject' => $this->propertyMessage->subject,
            ];
        } else {
            return [
                'type' => 'contact_message_received',
                'subject' => $this->contactMessage->subject,
            ];
        }
    }
}
