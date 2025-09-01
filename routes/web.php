<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\HomePage;
use App\Livewire\ContactPage;
use App\Livewire\AccompanimentForm;
use App\Livewire\CatalogPage;

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
Route::get('/contact', ContactPage::class)->name('contact');
Route::get('/accompagnement', AccompanimentForm::class)->name('accompagnement');
Route::get('/catalogue', CatalogPage::class)->name('catalogue');
Route::get('/nos-ventes', CatalogPage::class)->name('nos-ventes');
Route::get('/propriete/{id}', \App\Livewire\PropertyDetail::class)->name('property.detail');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.properties.index');
    });
    Route::resource('properties', \App\Http\Controllers\Admin\PropertyController::class);
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
