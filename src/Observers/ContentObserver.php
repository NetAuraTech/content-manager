<?php

namespace Netauratech\ContentManager\Observers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\File;
use JsonException;
use Netauratech\ContentManager\Jobs\PrecacheContent;
use Netauratech\ContentManager\Models\Content;
use Netauratech\CoreCms\Contracts\CacheServiceInterface;
use Netauratech\CoreCms\Contracts\PurgeUrlProviderInterface;

class ContentObserver
{
    /**
     * @throws ConnectionException
     * @throws JsonException
     */
    public function saving(Content $content): void
    {
        $path = storage_path("app/public/css");
        $css = '';
        foreach ($content->getContent() as $block) {
            if(!empty($block['layout-items'])) {
                foreach ($block['layout-items'] as $item) {
                    $css = $this->generate($item, $css);
                }
            }

            $css = $this->generate($block, $css);
        }

        File::ensureDirectoryExists($path);
        $filePath = "{$path}/{$content->slug}.css";
        File::put($filePath, $css);

        $this->purge($content);
    }

    static function generate(mixed $block, string $css): string
    {
        $hash = substr(md5(json_encode($block)), 0, 8);
        $baseClass = ".block__{$hash}";

        $rules = "";

        // → Background image
        if (!empty($block['background-image'])) {
            $rules .= "--background-image:url(".image_url($block['background-image']).");";

            foreach ([
                         'background-image-size',
                         'background-image-opacity',
                         'background-image-repeat',
                         'background-image-position-x',
                         'background-image-position-y'
                     ] as $key) {
                if (!empty($block[$key])) {
                    $rules .= "--$key:{$block[$key]};";
                }
            }
        }

        if (!empty($block['background-color']) && $block['background-color'] !== 'transparent') {
            $rules .= "--background-color:{$block['background-color']};";
        }

        if (trim($rules) !== "") {
            $css .= "{$baseClass}{{$rules}}";
        }

        // --- Title block ---
        if (!empty($block['title'])) {
            $titleRules = "";
            $titleClass = "{$baseClass}-title";

            if (!empty($block['title-color']) && $block['title-color'] !== 'transparent') {
                $titleRules .= "color:{$block['title-color']};";
            }

            if (!empty($block['title-border-style'])) {
                $titleRules .= "text-decoration-style:{$block['title-border-style']};";
                $titleRules .= "text-decoration-thickness:3px;";

                if (!empty($block['title-border-line'])) {
                    $titleRules .= "text-decoration-line:{$block['title-border-line']};";
                }

                if (!empty($block['title-border-color']) && $block['title-border-color'] !== 'transparent') {
                    $titleRules .= "text-decoration-color:{$block['title-border-color']};";
                }
            }

            if (!empty($block['title_animation']) && !empty($block['title_delay']) && $block['title_delay'] !== '0') {
                $titleRules .= "--delay:{$block['title_delay']}s;";
            }

            if (!empty($block['title-transition-name'])) {
                $titleRules .= "view-transition-name:{$block['title-transition-name']};";
            }

            if (trim($titleRules) !== "") {
                $css .= "{$titleClass}{{$titleRules}}";
            }
        }

        // --- Content block ---
        if (!empty($block['content'])) {
            $contentRules = "";
            $contentClass = "{$baseClass}-content";

            if (!empty($block['content_animation']) && !empty($block['content_delay']) && $block['content_delay'] !== '0') {
                $contentRules .= "--delay:{$block['content_delay']}s;";
            }

            if (!empty($block['content-transition-name'])) {
                $contentRules .= "view-transition-name:{$block['content-transition-name']};";
            }

            if (trim($contentRules) !== "") {
                $css .= "{$contentClass}{{$contentRules}}";
            }
        }

        // --- Img block ---
        if (!empty($block['media'])) {
            $mediaRules = "";
            $mediaClass = "{$baseClass}-media";

            if (isset($block['media-opacity'])) {
                $mediaRules .= "opacity:{$block['media-opacity']};";
            }

            if (trim($mediaRules) !== "") {
                $css .= "{$mediaClass}{{$mediaRules}}";
            }
        }

        // --- Layout block ---
        $layoutRules = "";
        $layoutClass = "{$baseClass}-layout";

        if (!empty($block['min-item-size'])) {
            $layoutRules .= "--min-item-size:{$block['min-item-size']}px;";
        }

        if (!empty($block['gap'])) {
            $layoutRules .= "--grid-gap:{$block['gap']}rem;";
        }

        if (trim($layoutRules) !== "") {
            $css .= "{$layoutClass}{{$layoutRules}}";
        }

        if ($css == "") {
            $css = "/* dummy */";
        }

        return $css;
    }

    /**
     * @throws ConnectionException
     */
    public function purge(Content $content): void
    {
        $urlsToPurge = [];

        /** @var PurgeUrlProviderInterface[] $providers */
        $providers = app()->tagged('content_purge_providers');

        if (in_array($content->type, ['footer', 'header'])) {
            app(CacheServiceInterface::class)->clear();

            foreach ($providers as $provider) {
                if ($provider instanceof PurgeUrlProviderInterface) {
                    $urlsToPurge = array_merge($urlsToPurge, $provider->getAllManagedUrls());
                }
            }
        } else {
            foreach ($providers as $provider) {
                if ($provider instanceof PurgeUrlProviderInterface) {
                    $urlsToPurge = array_merge($urlsToPurge, $provider->getUrlsToPurge($content));
                }
            }
        }

        $urlsToPurge = array_unique($urlsToPurge);

        if (!empty($urlsToPurge)) {
            app(CacheServiceInterface::class)->purgeItems($urlsToPurge);
        }

        foreach ($urlsToPurge as $url) {
            PrecacheContent::dispatch(url($url));
        }
    }
}