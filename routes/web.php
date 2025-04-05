<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\CsvImportController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PageBuilderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdvertentieController;
use App\Http\Controllers\VerhuurAdvertentieController;
use App\Http\Controllers\AdminController;
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
Route::get('/dashboard', [App\Http\Controllers\DashBoardController::class, 'index'])->middleware(['auth'])->name('dashboard');

// Groepeer routes die alleen voor ingelogde gebruikers toegankelijk zijn
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LogoutController::class, 'destroy'])
        ->name('logout');
    /*
     * Resource routes voor jouw Bazaar-app
     * Deze genereren automatisch de 7 RESTful routes (index, create, store, show, edit, update, destroy)
     */
    Route::get('/mydashboard', [\App\Http\Controllers\DashBoardController::class, 'index2'])->name('mydashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Bedrijf bedrijf
    Route::get('/bedrijfsprofiel/{id}', [BedrijfController::class, 'edit'])->name('bedrijf.edit');
    Route::patch('/bedrijfsprofiel', [BedrijfController::class, 'update'])->name('bedrijf.update');

    // csv import
    Route::get('/advertenties/csv-import/{type}/create', [CsvImportController::class, 'create'])
        ->name('advertenties.csvimport.create');

    // Verwerk de upload (store)
    Route::post('/advertenties/csv-import/{type}/store', [CsvImportController::class, 'store'])
        ->name('advertenties.csvimport.store');

    // Advertenties (koop/verkoop)
    Route::resource('advertenties', AdvertentieController::class)->parameters([
        'advertenties' => 'advertentie',
    ]);

    Route::get('/contracts/create{bedrijf_id}', [ContractController::class, 'create'])->name('contracts.create');
    Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');

    // Verhuuradvertenties
    Route::resource('verhuuradvertenties', VerhuurAdvertentieController::class)->parameters([
        'verhuuradvertenties' => 'verhuuradvertentie',
    ]);

    // web.php
    Route::get('contracts/goedkeuren', function () {
        return view('contracts.goedkeuren');
    })->name('contracts.goedkeuren'); // Correct spelling en name aanpassing



    Route::get('/admin/bedrijven-zonder-factuur', function () {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Je hebt geen toegang tot deze pagina.');
        }

        // Haal de bedrijven op zonder factuur
        $bedrijven = \App\Models\Bedrijf::doesntHave('contracts')->get();
        return view('admin.bedrijven_zonder_factuur', compact('bedrijven'));
    })->name('admin.bedrijven.zonder.factuur')->middleware('auth');

    // Landingspagina van bedrijf (publiek zichtbaar)
    Route::get('/{slug}', [LandingPageController::class, 'show'])->name('bedrijf.landing');

    // Pagebuilder voor bedrijven (alleen ingelogd)
    Route::get('/{slug}/pagebuilder', [PageBuilderController::class, 'edit'])->name('pagebuilder.edit');
    Route::post('/{slug}/pagebuilder', [PageBuilderController::class, 'update'])->name('pagebuilder.update');




    // Agenda
    Route::resource('agenda', AgendaController::class)->parameters([
        'agenda' => 'agendaItem',
    ]);

    Route::post('advertenties/{advertentie}/review', [ReviewController::class, 'store'])->name('reviews.store');

    // Reviews
    // Alleen index, store, destroy (geen update/edit nodig als je dat niet wilt)
    Route::resource('reviews', ReviewController::class)
        ->only(['index', 'store', 'destroy']);

    // Rental
    Route::get('/rentals/create/{verhuurAdvertentie}/{agendaItem}', [RentalController::class, 'create'])
        ->name('rentals.create');
    Route::post('/rentals/store', [RentalController::class, 'store'])
        ->name('rentals.store');
    Route::get('/rentals/{rental}', [RentalController::class, 'show'])
        ->name('rentals.show');

    // Favorieten
    Route::post('/favorites/toggle', [FavorietController::class, 'toggle'])->name('favorites.toggle');

    // Bids (biedingen)
    // Stel dat je alleen een overzicht, maken en verwijderen wilt:
    Route::post('/advertenties/{advertentie}/bids', [BidController::class, 'store'])->name('bids.store');
    Route::put('/bids', [BidController::class, 'update'])->name('bids.update');
    Route::delete('/bids/{advertentie}', [BidController::class, 'destroy'])->name('bids.destroy');

});
require __DIR__ . '/auth.php';
Auth::routes();



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
