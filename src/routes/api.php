<?php

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Netauratech\ContentManager\Http\Controllers\Api\TaxonomieController;

Route::middleware(['auth'])->group(function () {
    Route::get('/{type}/search', [TaxonomieController::class, 'search'])->name('taxonomie.search')->withoutMiddleware(VerifyCsrfToken::class);
});