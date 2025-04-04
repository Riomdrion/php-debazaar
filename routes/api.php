<?php

use App\Http\Controllers\Api\AdvertentieApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/advertenties', [AdvertentieApiController::class, 'index']);
});
