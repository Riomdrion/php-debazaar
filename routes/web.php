<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdvertentieController;
use App\Http\Controllers\VerhuurAdvertentieController;
use App\Http\Controllers\BedrijfController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\BidController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Hier registreer je web-routes voor je applicatie. Deze
| routes worden geladen door RouteServiceProvider in
| de "web" middleware group.
|
*/

// Eventueel: Auth-routes (afhankelijk van je setup)
Auth::routes();

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Voorbeeld: home controller
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Groepeer routes die alleen voor ingelogde gebruikers toegankelijk zijn
Route::middleware('auth')->group(function () {

    /*
     * Resource routes voor jouw Bazaar-app
     * Deze genereren automatisch de 7 RESTful routes (index, create, store, show, edit, update, destroy)
     */

    // Advertenties (koop/verkoop)
    Route::resource('advertenties', AdvertentieController::class);

    // Verhuur-advertenties
    Route::resource('verhuur', VerhuurAdvertentieController::class);

    // Bedrijf (voor whitelabel, eigen look & feel, etc.)
    Route::resource('bedrijven', BedrijfController::class);

    // Contracts (PDF-upload en -export)
    Route::resource('contracts', ContractController::class);

    // Reviews
    // Alleen index, store, destroy (geen update/edit nodig als je dat niet wilt)
    Route::resource('reviews', ReviewController::class)
        ->only(['index','store','destroy']);

    // Favorieten
    Route::resource('favorites', FavoriteController::class)
        ->only(['index','store','destroy']);

    // Bids (biedingen)
    // Stel dat je alleen een overzicht, maken en verwijderen wilt:
    Route::resource('bids', BidController::class)
        ->only(['index','store','destroy']);

    /*
     * Agenda - voorbeeld: alleen index (weergave planning),
     * je kunt er ook voor kiezen om 'store', 'update', etc. te bieden
     */
    Route::get('/agenda', [AgendaController::class, 'index'])
        ->name('agenda.index');
});
