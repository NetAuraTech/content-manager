<?php

use Illuminate\Support\Facades\Route;
use Netauratech\ContentManager\Http\Controllers\PageController;
use Netauratech\CoreCms\Contracts\ContentProviderInterface;

/**
 * Pages
 */
Route::get('/', [PageController::class, 'homepage'])->name('home');
Route::fallback(function (ContentProviderInterface $contentProvider) {
    $slug = request()->path();

    $page = $contentProvider->getContentBySlug($slug);

    if (!$page || $page->type !== 'page' || $page->status !== 'published') {
        abort(404, 'Page introuvable ou non publiée.');
    }

    return view('content-manager::front.page', [
        'page' => $page,
        'isHomepage' => false,
    ]);
})->name('page.show');