<?php

use App\Livewire\AboutPage;
use App\Livewire\AccompanimentForm;
use App\Livewire\CatalogPage;
use App\Livewire\ContactPage;
use App\Livewire\HomePage;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', HomePage::class)->name('home');
Route::get('/a-propos', AboutPage::class)->name('about');
Route::get('/contact', ContactPage::class)->name('contact');
Route::get('/accompagnement', AccompanimentForm::class)->name('accompagnement');
Route::get('/catalogue', CatalogPage::class)->name('catalogue');
Route::get('/nos-ventes', CatalogPage::class)->name('nos-ventes');
Route::get('/propriete/{id}', \App\Livewire\PropertyDetail::class)->name('property.detail');

// Admin routes
Route::middleware(['auth', 'verified', 'admin:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('properties', \App\Http\Controllers\Admin\PropertyController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('towns', \App\Http\Controllers\Admin\TownController::class);
    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);
    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);
    Route::resource('process-steps', \App\Http\Controllers\Admin\ProcessStepController::class);
    Route::resource('partners', \App\Http\Controllers\Admin\PartnerController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('messages', \App\Http\Controllers\Admin\MessageController::class);
    Route::post('messages/{message}/respond', [\App\Http\Controllers\Admin\MessageController::class, 'respond'])->name('messages.respond');
    Route::resource('applications', \App\Http\Controllers\Admin\ApplicationController::class);
    Route::patch('applications/{application}/status', [\App\Http\Controllers\Admin\ApplicationController::class, 'updateStatus'])->name('applications.update-status');

    // Messages de contact
    Route::resource('contact-messages', \App\Http\Controllers\Admin\ContactMessageController::class)->only(['index', 'show', 'destroy']);
    Route::post('contact-messages/{contactMessage}/mark-read', [\App\Http\Controllers\Admin\ContactMessageController::class, 'markAsRead'])->name('contact-messages.mark-read');
    Route::post('contact-messages/{contactMessage}/mark-unread', [\App\Http\Controllers\Admin\ContactMessageController::class, 'markAsUnread'])->name('contact-messages.mark-unread');
    Route::post('contact-messages/{contactMessage}/respond', [\App\Http\Controllers\Admin\ContactMessageController::class, 'respond'])->name('contact-messages.respond');
    Route::post('contact-messages/bulk-action', [\App\Http\Controllers\Admin\ContactMessageController::class, 'bulkAction'])->name('contact-messages.bulk-action');

    // Gestion du contenu de la page d'accueil
    Route::prefix('home-content')->name('home-content.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\HomeContentController::class, 'index'])->name('index');
        Route::put('/hero', [\App\Http\Controllers\Admin\HomeContentController::class, 'updateHero'])->name('update-hero');
        Route::put('/logo', [\App\Http\Controllers\Admin\HomeContentController::class, 'updateLogo'])->name('update-logo');
        Route::put('/cta', [\App\Http\Controllers\Admin\HomeContentController::class, 'updateCta'])->name('update-cta');
        Route::put('/footer-company', [\App\Http\Controllers\Admin\HomeContentController::class, 'updateFooterCompany'])->name('update-footer-company');
        Route::put('/footer-contact', [\App\Http\Controllers\Admin\HomeContentController::class, 'updateFooterContact'])->name('update-footer-contact');
        Route::put('/footer-legal', [\App\Http\Controllers\Admin\HomeContentController::class, 'updateFooterLegal'])->name('update-footer-legal');

        // Gestion du contenu de la page de contact
        Route::put('/contact-header', [\App\Http\Controllers\Admin\HomeContentController::class, 'updateContactHeader'])->name('update-contact-header');
        Route::put('/contact-form', [\App\Http\Controllers\Admin\HomeContentController::class, 'updateContactForm'])->name('update-contact-form');
        Route::put('/contact-info', [\App\Http\Controllers\Admin\HomeContentController::class, 'updateContactInfo'])->name('update-contact-info');
        Route::put('/contact-why-choose', [\App\Http\Controllers\Admin\HomeContentController::class, 'updateContactWhyChoose'])->name('update-contact-why-choose');
        Route::put('/contact-partner', [\App\Http\Controllers\Admin\HomeContentController::class, 'updateContactPartner'])->name('update-contact-partner');
    });
});

// Client routes
Route::prefix('client')->name('client.')->middleware(['auth', 'verified', 'admin:client'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Client\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('applications', \App\Http\Controllers\Client\ApplicationController::class);

    // Messages du client
    Route::get('messages', [\App\Http\Controllers\Client\MessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [\App\Http\Controllers\Client\MessageController::class, 'show'])->name('messages.show');
    Route::get('contact-messages/{contactMessage}', [\App\Http\Controllers\Client\MessageController::class, 'showContact'])->name('contact-messages.show');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Routes de profil
Route::middleware(['auth'])->group(function () {
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile');
    Route::get('profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('profile/show', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.show');
});

require __DIR__.'/auth.php';

// Routes de test pour les pages d'erreur (à supprimer en production)
Route::get('/test-error/{code}', function ($code) {
    switch ($code) {
        case '404':
            abort(404);
        case '500':
            abort(500);
        case '403':
            abort(403);
        case '419':
            abort(419);
        case '429':
            abort(429);
        default:
            abort(404);
    }
})->where('code', '[0-9]+');

// Route pour servir les fichiers de storage en développement
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/'.$path);

    if (! file_exists($fullPath)) {
        abort(404);
    }

    $mimeType = mime_content_type($fullPath) ?: 'application/octet-stream';
    $content = file_get_contents($fullPath);

    return response($content, 200, [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*')->name('storage.file');
