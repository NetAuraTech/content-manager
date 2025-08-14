<?php

namespace Netauratech\ContentManager\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Netauratech\ContentManager\Models\Category;
use Netauratech\ContentManager\Models\Content;
use Netauratech\ContentManager\Models\Tag;
use netauratech\CoreCms\Contracts\ContentProviderInterface;

class ContentProvider implements ContentProviderInterface
{
    /**
     * Retrieves all articles (Content of type ‘article’).
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getArticles(int $perPage = 10): LengthAwarePaginator
    {
        return Content::where('type', 'article')
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Retrieves articles from category.
     *
     * @param string $slug
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getArticlesByCategory(string $slug, int $perPage = 10): LengthAwarePaginator
    {
        return Content::where('type', 'article')
            ->where('status', 'published')
            ->whereHas('categories', function ($query) use ($slug) {
                $query->where('categories.slug', $slug);
            })
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Returns categories with the number of articles
     *
     * @return Collection
     */
    public function countCategories(): Collection
    {
        return DB::table('categories')
            ->leftJoin('content_category', 'categories.id', '=', 'content_category.category_id')
            ->leftJoin('contents', function ($join) {
                $join->on('content_category.content_id', '=', 'contents.id')
                    ->where('contents.status', 'published')
                    ->where('contents.type', 'article');
            })
            ->select(DB::raw('categories.*, COUNT(DISTINCT contents.id) as count'))
            ->groupBy('categories.id', 'categories.name', 'categories.slug', 'categories.created_at', 'categories.updated_at')
            ->orderBy('name')
            ->get();
    }

    /**
     * Retrieves all pages (Content type ‘page’).
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPages(int $perPage = 10): LengthAwarePaginator
    {
        return Content::where('type', 'page')
            ->where('status', 'published')
            ->orderBy('title', 'asc')
            ->paginate($perPage);
    }

    /**
     * Retrieves all templates (Content type ‘template’).
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getTemplates(int $perPage = 10): LengthAwarePaginator
    {
        return Content::where('type', 'template')
            ->where('status', 'published')
            ->orderBy('title', 'asc')
            ->paginate($perPage);
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

    /**
     * Transforms a string containing a list of names
     * separated by commas into a collection of corresponding Eloquent objects,
     * or an empty array.
     *
     * @param string|null $value A string containing item names separated by commas.
     * @param string $model The name of the target model.
     * @return Collection|array A collection of corresponding Eloquent objects,
     * or an empty array if the string is empty, or if no elements match the given model.
     */
    public function reverseTransform(?string $value, string $model): Collection|array
    {
        if (empty($value)) {
            return [];
        }

        $versions = [];
        $tags = explode(',', $value);
        foreach ($tags as $tag) {
            $parts = explode(':', trim($tag));
            if (! empty($parts[0])) {
                $versions[$parts[0]] = $parts[1] ?? null;
            }
        }

        return match ($model) {
            'category' => Category::whereIn('name', array_keys($versions))->get(),
            'tag' => Tag::whereIn('name', array_keys($versions))->get(),
            default => [],
        };
    }
}
