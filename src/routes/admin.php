<?php

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Netauratech\ContentManager\Http\Controllers\Admin\CategoryController;
use Netauratech\ContentManager\Http\Controllers\Admin\ContentController;
use Netauratech\ContentManager\Http\Controllers\Admin\TagController;

/**
 * Content (page, article, template, ...)
 */
Route::get('contents/{type}', [ContentController::class, 'index'])->name('contents.index');
Route::get('contents/{type}/create', [ContentController::class, 'create'])->name('contents.create');
Route::post('contents/{type}', [ContentController::class, 'store'])->name('contents.store');
Route::get('contents/{content}/edit', [ContentController::class, 'edit'])->name('contents.edit');
Route::put('contents/{content}', [ContentController::class, 'update'])->name('contents.update');
Route::delete('contents/{content}', [ContentController::class, 'destroy'])->name('contents.destroy');
Route::post('contents/{type}/preview', [ContentController::class, 'preview'])->name('contents.preview')->withoutMiddleware(VerifyCsrfToken::class);

/**
 * Categories
 */
Route::resource('categories', CategoryController::class);

/**
 * Tags
 */
Route::resource('tags', TagController::class);