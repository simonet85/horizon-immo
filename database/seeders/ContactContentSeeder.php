<?php

namespace Database\Seeders;

use App\Models\ContactContent;
use Illuminate\Database\Seeder;

class ContactContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Section Header
        ContactContent::updateOrCreate(['section' => 'header', 'key' => 'title'], [
            'value' => 'Contactez-Nous',
            'is_active' => true,
            'order' => 1,
        ]);

        ContactContent::updateOrCreate(['section' => 'header', 'key' => 'description'], [
            'value' => 'Notre équipe d\'experts est à votre disposition pour répondre à toutes vos questions sur l\'immobilier en Afrique du Sud',
            'is_active' => true,
            'order' => 2,
        ]);

        // Section Formulaire
        ContactContent::updateOrCreate(['section' => 'form', 'key' => 'section_title'], [
            'value' => 'Envoyez-nous un message',
            'is_active' => true,
            'order' => 1,
        ]);

        ContactContent::updateOrCreate(['section' => 'form', 'key' => 'subtitle'], [
            'value' => 'Nous vous répondrons dans les plus brefs délais',
            'is_active' => true,
            'order' => 2,
        ]);

        ContactContent::updateOrCreate(['section' => 'form', 'key' => 'label_prenom'], [
            'value' => 'Prénom',
            'is_active' => true,
            'order' => 3,
        ]);

        ContactContent::updateOrCreate(['section' => 'form', 'key' => 'label_nom'], [
            'value' => 'Nom',
            'is_active' => true,
            'order' => 4,
        ]);

        ContactContent::updateOrCreate(['section' => 'form', 'key' => 'label_email'], [
            'value' => 'Email',
            'is_active' => true,
            'order' => 5,
        ]);

        ContactContent::updateOrCreate(['section' => 'form', 'key' => 'label_telephone'], [
            'value' => 'Téléphone',
            'is_active' => true,
            'order' => 6,
        ]);

        ContactContent::updateOrCreate(['section' => 'form', 'key' => 'label_sujet'], [
            'value' => 'Sujet',
            'is_active' => true,
            'order' => 7,
        ]);

        ContactContent::updateOrCreate(['section' => 'form', 'key' => 'label_message'], [
            'value' => 'Message',
            'is_active' => true,
            'order' => 8,
        ]);

        ContactContent::updateOrCreate(['section' => 'form', 'key' => 'button_text'], [
            'value' => 'Envoyer le message',
            'is_active' => true,
            'order' => 9,
        ]);

        // Section Informations de Contact
        ContactContent::updateOrCreate(['section' => 'contact_info', 'key' => 'section_title'], [
            'value' => 'Informations de Contact',
            'is_active' => true,
            'order' => 1,
        ]);

        ContactContent::updateOrCreate(['section' => 'contact_info', 'key' => 'address_label'], [
            'value' => 'Adresse',
            'is_active' => true,
            'order' => 2,
        ]);

        ContactContent::updateOrCreate(['section' => 'contact_info', 'key' => 'address_line1'], [
            'value' => '123 Rue de la République',
            'is_active' => true,
            'order' => 3,
        ]);

        ContactContent::updateOrCreate(['section' => 'contact_info', 'key' => 'address_line2'], [
            'value' => '75001 Paris, France',
            'is_active' => true,
            'order' => 4,
        ]);

        ContactContent::updateOrCreate(['section' => 'contact_info', 'key' => 'phone_label'], [
            'value' => 'Téléphone',
            'is_active' => true,
            'order' => 5,
        ]);

        ContactContent::updateOrCreate(['section' => 'contact_info', 'key' => 'phone_france'], [
            'value' => '+33 1 XX XX XX XX',
            'is_active' => true,
            'order' => 6,
        ]);

        ContactContent::updateOrCreate(['section' => 'contact_info', 'key' => 'phone_south_africa'], [
            'value' => '+27 XXX XXX XXXX (Afrique du Sud)',
            'is_active' => true,
            'order' => 7,
        ]);

        ContactContent::updateOrCreate(['section' => 'contact_info', 'key' => 'email_label'], [
            'value' => 'Email',
            'is_active' => true,
            'order' => 8,
        ]);

        ContactContent::updateOrCreate(['section' => 'contact_info', 'key' => 'email_contact'], [
            'value' => 'contact@immobilier-sa.com',
            'is_active' => true,
            'order' => 9,
        ]);

        ContactContent::updateOrCreate(['section' => 'contact_info', 'key' => 'email_rh'], [
            'value' => 'rh-ghius@immobilier-sa.com',
            'is_active' => true,
            'order' => 10,
        ]);

        ContactContent::updateOrCreate(['section' => 'contact_info', 'key' => 'hours_label'], [
            'value' => 'Horaires',
            'is_active' => true,
            'order' => 11,
        ]);

        ContactContent::updateOrCreate(['section' => 'contact_info', 'key' => 'hours_weekdays'], [
            'value' => 'Lundi - Vendredi: 9h - 18h',
            'is_active' => true,
            'order' => 12,
        ]);

        ContactContent::updateOrCreate(['section' => 'contact_info', 'key' => 'hours_saturday'], [
            'value' => 'Samedi: 9h - 13h',
            'is_active' => true,
            'order' => 13,
        ]);

        ContactContent::updateOrCreate(['section' => 'contact_info', 'key' => 'hours_sunday'], [
            'value' => 'Dimanche: Fermé',
            'is_active' => true,
            'order' => 14,
        ]);

        // Section Pourquoi Nous Choisir
        ContactContent::updateOrCreate(['section' => 'why_choose', 'key' => 'section_title'], [
            'value' => 'Pourquoi Nous Choisir ?',
            'is_active' => true,
            'order' => 1,
        ]);

        ContactContent::updateOrCreate(['section' => 'why_choose', 'key' => 'advantage_1'], [
            'value' => 'Expertise locale en Afrique du Sud',
            'is_active' => true,
            'order' => 2,
        ]);

        ContactContent::updateOrCreate(['section' => 'why_choose', 'key' => 'advantage_2'], [
            'value' => 'Accompagnement personnalisé',
            'is_active' => true,
            'order' => 3,
        ]);

        ContactContent::updateOrCreate(['section' => 'why_choose', 'key' => 'advantage_3'], [
            'value' => 'Partenaire Standard Bank',
            'is_active' => true,
            'order' => 4,
        ]);

        // Section Partenaire Officiel
        ContactContent::updateOrCreate(['section' => 'partner', 'key' => 'title'], [
            'value' => 'Partenaire Officiel',
            'is_active' => true,
            'order' => 1,
        ]);

        ContactContent::updateOrCreate(['section' => 'partner', 'key' => 'partner_name'], [
            'value' => 'Standard Bank',
            'is_active' => true,
            'order' => 2,
        ]);

        ContactContent::updateOrCreate(['section' => 'partner', 'key' => 'description'], [
            'value' => 'Partenaire de financement privilégié',
            'is_active' => true,
            'order' => 3,
        ]);
    }
}
