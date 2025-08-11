<?php

namespace Netauratech\ContentManager;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Netauratech\ContentManager\Models\Content;
use Netauratech\ContentManager\Observers\ContentObserver;
use Netauratech\ContentManager\Services\ContentProvider;
use Netauratech\CoreCms\Contracts\ContentProviderInterface;
use Netauratech\CoreCms\Events\LangLoaded;
use Netauratech\CoreCms\Services\Admin\MenuManager;
use Netauratech\CoreCms\Services\AssetManager;

class ContentManagerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->extend(ContentProviderInterface::class, function ($service, $app) {
            return new ContentProvider();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(MenuManager $menuManager, AssetManager $assetManager): void
    {
        $this->publishes([
            __DIR__.'/database/migrations/' => database_path('migrations'),
        ], 'content-manager-migrations');

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->publishes([
            __DIR__.'/database/seeders/' => database_path('seeders')
        ], 'content-manager-seeders');

        // Load all views
        $this->loadViewsFrom(__DIR__.'/resources/views', 'content-manager');

        // Register Assets
        $packageBasePath = realpath(__DIR__ . '/../');
        $composerJsonPath = $packageBasePath . '/composer.json';

        $assetManager->registerTranslationPath('content-manager', __DIR__.'/lang');

        if (file_exists($composerJsonPath)) {
            $composerJsonContent = json_decode(file_get_contents($composerJsonPath), true);
            if (isset($composerJsonContent['name'])) {
                $packageName = $composerJsonContent['name'];
            }
            $assetManager->registerAppJs("vendor/{$packageName}/src/resources/ts/app.ts");
            $assetManager->registerAdminJs("vendor/{$packageName}/src/resources/ts/admin.ts");
        }

        // Lang
        $this->loadTranslationsFrom(__DIR__.'/lang', 'content-manager');
        LangLoaded::dispatch('content-manager');

        // Allows you to publish translations of the package
        $this->publishes([
            __DIR__.'/lang' => $this->app->langPath('vendor/content-manager'),
        ], 'content-manager-translations');

        // Routes admin
        Route::group([
            'middleware' => config('core-cms.admin.middleware'),
            'prefix' => config('core-cms.admin.prefix'),
            'as' => config('core-cms.admin.name'),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/routes/admin.php');
        });

        //Route Web
        Route::group([
            'middleware' => ['web'],
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        });

        Content::observe(ContentObserver::class);

        $menuManager->registerMenuItem('content-management', [
            'label' => __('content-manager::admin.content.value'),
            'children' => [
                [
                    'label' => trans_choice('content-manager::admin.content.page.value', 0),
                    'icon'  => 'page',
                    'route' => 'admin.contents.index',
                    'params' => ['type' => 'page'],
                    'can'   => 'content-list'
                ],
                [
                    'label' => trans_choice('content-manager::admin.content.template.value', 0),
                    'icon'  => 'template',
                    'route' => 'admin.contents.index',
                    'params' => ['type' => 'template'],
                    'can'   => 'content-list'
                ]
            ]
        ]);
    }
}