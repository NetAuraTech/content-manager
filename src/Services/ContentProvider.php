<?php

namespace Netauratech\ContentManager\Services;

use Illuminate\Support\Collection;
use Netauratech\ContentManager\Models\Content;
use netauratech\CoreCms\Contracts\ContentProviderInterface;

class ContentProvider implements ContentProviderInterface
{
    /**
     * Retrieves all articles (Content of type ‘article’).
     *
     * @return Collection
     */
    public function getArticles(): Collection
    {
        return Content::where('type', 'article')
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->get();
    }

    /**
     * Retrieves all pages (Content type ‘page’).
     *
     * @return Collection
     */
    public function getPages(): Collection
    {
        return Content::where('type', 'page')
            ->where('status', 'published')
            ->orderBy('title', 'asc')
            ->get();
    }

    /**
     * Retrieves a content item by its ID.
     *
     * @param int $id
     * @return object|null The content model or null if not found.
     */
    public function getContentById(int $id): ?object
    {
        return Content::find($id);
    }

    /**
     * Retrieves a content item by its slug.
     *
     * @param string $slug
     * @return object|null The content model or null if not found.
     */
    public function getContentBySlug(string $slug): ?object
    {
        return Content::where('slug', $slug)
            ->where('status', 'published')
            ->first();
    }

    /**
     * Retrieves the header content (Content type ‘header’).
     *
     * @return object|null The header content model or null if not found.
     */
    public function getHeaderContent(): ?object
    {
        // TODO
        return null;
    }

    /**
     * Retrieves the footer content (Content of type ‘footer’).
     *
     * @return object|null The footer content model or null if not found.
     */
    public function getFooterContent(): ?object
    {
        // TODO
        return null;
    }
}
