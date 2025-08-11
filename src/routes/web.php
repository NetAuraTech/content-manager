<?php

use Illuminate\Support\Facades\Route;
use Netauratech\ContentManager\Http\Controllers\FormSubmissionController;
use Netauratech\ContentManager\Http\Controllers\PageController;
use Netauratech\ContentManager\Http\Controllers\SeoContentController;
use Netauratech\CoreCms\Contracts\ContentProviderInterface;
use Netauratech\CoreCms\Form\FormRegistry;

/**
 * Pages
 */
Route::get('/', [PageController::class, 'homepage'])->name('home');
Route::get('/sitemap.xml', [SeoContentController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoContentController::class, 'robotsTxt'])->name('robots.txt');
Route::post('/forms/{slug}/{formType}', [FormSubmissionController::class, 'submit'])->name('forms.submit');

Route::fallback(function (ContentProviderInterface $contentProvider, FormRegistry $formRegistry) {
    $slug = request()->path();

    $content = $contentProvider->getContentBySlug($slug);

    if (!$content || $content->type !== 'page' || $content->status !== 'published') {
        abort(404, 'Page introuvable ou non publiée.');
    }

    return view('content-manager::front.page', [
        'content' => $content,
        'isHomepage' => false,
        'metas' => $formRegistry->getFormFields('content_meta'),
    ]);
})->name('page.show');