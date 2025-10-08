<?php

namespace Database\Seeders;

use App\Models\FooterContent;
use Illuminate\Database\Seeder;

class FooterContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Informations entreprise
        FooterContent::updateOrCreate(
            ['section' => 'company', 'key' => 'company_name'],
            ['value' => 'Immobilier SA']
        );

        FooterContent::updateOrCreate(
            ['section' => 'company', 'key' => 'company_description'],
            ['value' => 'Votre partenaire de confiance pour investir dans l\'immobilier sud-africain. Expertise, accompagnement personnalisé et financement sécurisé.']
        );

        FooterContent::updateOrCreate(
            ['section' => 'company', 'key' => 'certification_1'],
            ['value' => 'Certifié & Assuré']
        );

        FooterContent::updateOrCreate(
            ['section' => 'company', 'key' => 'certification_2'],
            ['value' => 'Expert Agréé']
        );

        // Contact
        FooterContent::updateOrCreate(
            ['section' => 'contact', 'key' => 'email'],
            ['value' => 'contact@immobilier-sa.com']
        );

        FooterContent::updateOrCreate(
            ['section' => 'contact', 'key' => 'phone_france'],
            ['value' => '+33 1 XX XX XX XX']
        );

        FooterContent::updateOrCreate(
            ['section' => 'contact', 'key' => 'phone_south_africa'],
            ['value' => '+27 XXXX XX XXXX (Afrique du Sud)']
        );

        FooterContent::updateOrCreate(
            ['section' => 'contact', 'key' => 'address'],
            ['value' => 'Bureau France & Afrique du Sud - Sur rendez-vous uniquement']
        );

        FooterContent::updateOrCreate(
            ['section' => 'contact', 'key' => 'hours_weekdays'],
            ['value' => 'Lun - Ven: 9h - 18h']
        );

        FooterContent::updateOrCreate(
            ['section' => 'contact', 'key' => 'hours_saturday'],
            ['value' => 'Sam: 9h - 13h']
        );

        FooterContent::updateOrCreate(
            ['section' => 'contact', 'key' => 'hours_sunday'],
            ['value' => 'Dim: Sur rendez-vous']
        );

        // Légal
        FooterContent::updateOrCreate(
            ['section' => 'legal', 'key' => 'copyright_year'],
            ['value' => '2024']
        );

        FooterContent::updateOrCreate(
            ['section' => 'legal', 'key' => 'company_legal_name'],
            ['value' => 'Immobilier SA. Tous droits réservés.']
        );

        FooterContent::updateOrCreate(
            ['section' => 'legal', 'key' => 'partner_name'],
            ['value' => 'Standard Bank']
        );

        FooterContent::updateOrCreate(
            ['section' => 'legal', 'key' => 'partner_description'],
            ['value' => 'Solutions de financement privilégiées']
        );
    }
}
