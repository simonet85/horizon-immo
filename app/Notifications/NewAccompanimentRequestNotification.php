<?php

namespace App\Notifications;

use App\Models\AccompanimentRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAccompanimentRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public AccompanimentRequest $request
    ) {}

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
        $fullName = $this->request->first_name.' '.$this->request->last_name;

        return (new MailMessage)
            ->subject('Nouvelle demande d\'accompagnement - ZB Investments')
            ->bcc(config('mail.from.address')) // Copie vers l'email professionnel
            ->greeting('Bonjour !')
            ->line('Une nouvelle demande d\'accompagnement immobilier a été reçue sur le site ZB Investments.')
            ->line('**Informations du demandeur :**')
            ->line('**Nom :** '.$fullName)
            ->line('**Email :** '.$this->request->email)
            ->line('**Téléphone :** '.$this->request->phone)
            ->line('**Pays de résidence :** '.$this->request->country_residence)
            ->line('**Âge :** '.$this->request->age.' ans')
            ->line('**Profession :** '.$this->request->profession)
            ->line('')
            ->line('**Projet immobilier :**')
            ->line('**Ville souhaitée :** '.$this->request->desired_city)
            ->line('**Type de bien :** '.$this->request->property_type)
            ->line('**Budget :** '.$this->request->budget_range)
            ->line('')
            ->line('**Informations financières :**')
            ->line('**Revenu mensuel :** '.number_format($this->request->monthly_income, 0, ',', ' ').' FCFA')
            ->line('**Apport personnel :** '.$this->request->personal_contribution_percentage.'%')
            ->line('**Durée du prêt souhaitée :** '.$this->request->loan_duration.' ans')
            ->line('**Dettes existantes :** '.($this->request->existing_debt ? number_format($this->request->existing_debt, 0, ',', ' ').' FCFA' : 'Aucune'))
            ->action('Voir dans l\'admin', url('/admin/applications/'.$this->request->id))
            ->line('Vous pouvez contacter le client pour discuter de son projet.')
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
            'request_id' => $this->request->id,
            'sender_name' => $this->request->first_name.' '.$this->request->last_name,
            'sender_email' => $this->request->email,
            'budget_range' => $this->request->budget_range,
            'desired_city' => $this->request->desired_city,
        ];
    }
}
