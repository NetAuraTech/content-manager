<?php

use Illuminate\Support\Facades\Route;
use Netauratech\ContentManager\Http\Controllers\PageController;

/**
 * Pages
 */
Route::get('/', [PageController::class, 'homepage'])->name('homepage');
Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');