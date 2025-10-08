<?php

namespace Netauratech\ContentManager;

use Database\Seeders\ContentTableSeeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Netauratech\ContentManager\Models\Content;
use Netauratech\ContentManager\Observers\ContentObserver;
use Netauratech\ContentManager\Services\ContentProvider;
use Netauratech\ContentManager\Services\ContentPurgeProvider;
use Netauratech\ContentManager\Services\Shortcode\TemplateShortcode;
use Netauratech\CoreCms\Contracts\ContentProviderInterface;
use Netauratech\CoreCms\Events\ContentSaved;
use Netauratech\CoreCms\Services\AbstractCmsServiceProvider;
use Netauratech\CoreCms\Services\Admin\MenuManager;
use Netauratech\CoreCms\Services\Shortcode\ShortcodeRegistry;

class ContentManagerServiceProvider extends AbstractCmsServiceProvider
{
    protected function getPackageName(): string
    {
        return 'content-manager';
    }

    protected function getBootstrapConfig(): array
    {
        $config = parent::getBootstrapConfig();

        $config['routes']['api'] = false;
        $config['routes']['auth'] = false;
        $config['publishes']['config'] = false;
        $config['publishes']['assets'] = false;

        return $config;
    }

    protected function getSeeders(): array
    {
        return [
            ContentTableSeeder::class,
        ];
    }
    public function register(): void
    {
        parent::register();

        $this->app->extend(ContentProviderInterface::class, function ($service, $app) {
            return new ContentProvider();
        });

        $this->app->tag(ContentPurgeProvider::class, 'content_purge_providers');
    }

    public function boot(MenuManager $menuManager, ShortcodeRegistry $shortcodeRegistry): void {
        $this->bootstrapPackage();

        $shortcodeRegistry->register('template', new TemplateShortcode());

        Content::observe(ContentObserver::class);

        Event::listen(ContentSaved::class, function (ContentSaved $event) {
            if ($event->content->type === "template") {
                Cache::store('database')->forget('options');
            }
        });

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