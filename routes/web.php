<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdvertentieController;
use App\Http\Controllers\VerhuurAdvertentieController;
use App\Http\Controllers\BedrijfController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\FavorietController;
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
    return view('../auth/login');
});

// Voorbeeld: home controller
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Groepeer routes die alleen voor ingelogde gebruikers toegankelijk zijn
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LogoutController::class, 'destroy'])
        ->name('logout');
    /*
     * Resource routes voor jouw Bazaar-app
     * Deze genereren automatisch de 7 RESTful routes (index, create, store, show, edit, update, destroy)
     */

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Advertenties (koop/verkoop)
    Route::resource('advertenties', AdvertentieController::class)->parameters([
        'advertenties' => 'advertentie',
    ]);

    Route::resource('verhuuradvertenties', VerhuurAdvertentieController::class);

    Route::post('advertenties/{advertentie}/review', [ReviewController::class, 'store'])->name('reviews.store');

    Route::get('agenda', [AgendaController::class, 'index'])->name('agenda.index');

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
    Route::post('/favorites/toggle', [FavorietController::class, 'toggle'])->name('favorites.toggle');


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
require __DIR__.'/auth.php';
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
