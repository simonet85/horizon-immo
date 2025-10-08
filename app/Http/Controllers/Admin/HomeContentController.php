<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactContent;
use App\Models\FooterContent;
use App\Models\HomeContent;
use App\Models\Partner;
use App\Models\ProcessStep;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hero = HomeContent::where('section', 'hero')->get()->keyBy('key');
        $cta = HomeContent::where('section', 'cta')->first();
        $navigation = HomeContent::where('section', 'navigation')->get()->keyBy('key');
        $services = Service::active()->ordered()->get();
        $testimonials = Testimonial::active()->ordered()->get();
        $processSteps = ProcessStep::active()->ordered()->get();
        $partners = Partner::active()->ordered()->get();

        // Footer content
        $footerCompany = FooterContent::getBySection('company');
        $footerContact = FooterContent::getBySection('contact');
        $footerLegal = FooterContent::getBySection('legal');

        // Contact content
        $contactHeader = ContactContent::getBySection('header');
        $contactForm = ContactContent::getBySection('form');
        $contactInfo = ContactContent::getBySection('contact_info');
        $contactWhyChoose = ContactContent::getBySection('why_choose');
        $contactPartner = ContactContent::getBySection('partner');

        return view('admin.home-content.index', compact(
            'hero',
            'cta',
            'navigation',
            'services',
            'testimonials',
            'processSteps',
            'partners',
            'footerCompany',
            'footerContact',
            'footerLegal',
            'contactHeader',
            'contactForm',
            'contactInfo',
            'contactWhyChoose',
            'contactPartner'
        ));
    }

    /**
     * Update hero section content
     */
    public function updateHero(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',
            'button_1_text' => 'required|string|max:255',
            'button_1_url' => 'required|string|max:255',
            'button_2_text' => 'required|string|max:255',
            'button_2_url' => 'required|string|max:255',
            'background_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // Mise à jour des champs texte
        HomeContent::updateOrCreate(['section' => 'hero', 'key' => 'titre_principal'], [
            'value' => $validated['title'],
            'type' => 'text',
            'active' => true,
        ]);

        HomeContent::updateOrCreate(['section' => 'hero', 'key' => 'sous_titre'], [
            'value' => $validated['subtitle'],
            'type' => 'text',
            'active' => true,
        ]);

        HomeContent::updateOrCreate(['section' => 'hero', 'key' => 'bouton_principal_text'], [
            'value' => $validated['button_1_text'],
            'type' => 'text',
            'active' => true,
        ]);

        HomeContent::updateOrCreate(['section' => 'hero', 'key' => 'bouton_principal_url'], [
            'value' => $validated['button_1_url'],
            'type' => 'text',
            'active' => true,
        ]);

        HomeContent::updateOrCreate(['section' => 'hero', 'key' => 'bouton_secondaire_text'], [
            'value' => $validated['button_2_text'],
            'type' => 'text',
            'active' => true,
        ]);

        HomeContent::updateOrCreate(['section' => 'hero', 'key' => 'bouton_secondaire_url'], [
            'value' => $validated['button_2_url'],
            'type' => 'text',
            'active' => true,
        ]);

        // Gestion de l'image de fond
        if ($request->hasFile('background_image')) {
            $image = $request->file('background_image');
            $imageName = time().'_hero.'.$image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images/hero', $imageName, 'public');

            HomeContent::updateOrCreate(['section' => 'hero', 'key' => 'background_image'], [
                'value' => 'Image de fond du hero',
                'type' => 'image',
                'image_path' => $imagePath,
                'active' => true,
            ]);
        }

        return redirect()->back()->with('success', 'Section Hero mise à jour avec succès');
    }

    /**
     * Update logo
     */
    public function updateLogo(Request $request)
    {
        $validated = $request->validate([
            'logo' => 'required|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $imageName = time().'_logo.'.$image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images/logo', $imageName, 'public');

            HomeContent::updateOrCreate(['section' => 'navigation', 'key' => 'logo'], [
                'value' => 'Logo du site',
                'type' => 'image',
                'image_path' => $imagePath,
                'active' => true,
            ]);
        }

        return redirect()->back()->with('success', 'Logo mis à jour avec succès');
    }

    /**
     * Update CTA section content
     */
    public function updateCta(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'button_1_text' => 'required|string|max:255',
            'button_1_url' => 'required|string|max:255',
            'button_2_text' => 'required|string|max:255',
            'button_2_url' => 'required|string|max:255',
        ]);

        HomeContent::updateOrCreate(
            ['section' => 'cta'],
            $validated
        );

        return redirect()->back()->with('success', 'Section Call to Action mise à jour avec succès');
    }

    /**
     * Update footer company section content
     */
    public function updateFooterCompany(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_description' => 'required|string',
            'certification_1' => 'nullable|string|max:255',
            'certification_2' => 'nullable|string|max:255',
        ]);

        FooterContent::updateSection('company', $validated);

        return redirect()->back()->with('success', 'Informations entreprise mises à jour avec succès');
    }

    /**
     * Update footer contact section content
     */
    public function updateFooterContact(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'phone_france' => 'required|string|max:255',
            'phone_south_africa' => 'required|string|max:255',
            'address' => 'required|string',
            'hours_weekdays' => 'required|string|max:255',
            'hours_saturday' => 'required|string|max:255',
            'hours_sunday' => 'required|string|max:255',
        ]);

        FooterContent::updateSection('contact', $validated);

        return redirect()->back()->with('success', 'Informations de contact mises à jour avec succès');
    }

    /**
     * Update footer legal section content
     */
    public function updateFooterLegal(Request $request)
    {
        $validated = $request->validate([
            'copyright_year' => 'required|string|max:4',
            'company_legal_name' => 'required|string|max:255',
            'partner_name' => 'required|string|max:255',
            'partner_description' => 'required|string|max:255',
        ]);

        FooterContent::updateSection('legal', $validated);

        return redirect()->back()->with('success', 'Informations légales mises à jour avec succès');
    }

    /**
     * Update contact header content
     */
    public function updateContactHeader(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        ContactContent::updateSection('header', $validated);

        return redirect()->back()->with('success', 'En-tête de contact mis à jour avec succès');
    }

    /**
     * Update contact form content
     */
    public function updateContactForm(Request $request)
    {
        $validated = $request->validate([
            'section_title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'label_prenom' => 'required|string|max:255',
            'label_nom' => 'required|string|max:255',
            'label_email' => 'required|string|max:255',
            'label_telephone' => 'required|string|max:255',
            'label_sujet' => 'required|string|max:255',
            'label_message' => 'required|string|max:255',
            'button_text' => 'required|string|max:255',
        ]);

        ContactContent::updateSection('form', $validated);

        return redirect()->back()->with('success', 'Formulaire de contact mis à jour avec succès');
    }

    /**
     * Update contact info content
     */
    public function updateContactInfo(Request $request)
    {
        $validated = $request->validate([
            'section_title' => 'required|string|max:255',
            'address_label' => 'required|string|max:255',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'required|string|max:255',
            'phone_label' => 'required|string|max:255',
            'phone_france' => 'required|string|max:255',
            'phone_south_africa' => 'required|string|max:255',
            'email_label' => 'required|string|max:255',
            'email_contact' => 'required|email|max:255',
            'email_rh' => 'required|email|max:255',
            'hours_label' => 'required|string|max:255',
            'hours_weekdays' => 'required|string|max:255',
            'hours_saturday' => 'required|string|max:255',
            'hours_sunday' => 'required|string|max:255',
        ]);

        ContactContent::updateSection('contact_info', $validated);

        return redirect()->back()->with('success', 'Informations de contact mises à jour avec succès');
    }

    /**
     * Update contact why choose content
     */
    public function updateContactWhyChoose(Request $request)
    {
        $validated = $request->validate([
            'section_title' => 'required|string|max:255',
            'advantage_1' => 'required|string|max:255',
            'advantage_2' => 'required|string|max:255',
            'advantage_3' => 'required|string|max:255',
        ]);

        ContactContent::updateSection('why_choose', $validated);

        return redirect()->back()->with('success', 'Section "Pourquoi nous choisir" mise à jour avec succès');
    }

    /**
     * Update contact partner content
     */
    public function updateContactPartner(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'partner_name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        ContactContent::updateSection('partner', $validated);

        return redirect()->back()->with('success', 'Informations partenaire mises à jour avec succès');
    }
}
