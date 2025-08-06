<?php

namespace Netauratech\ContentManager\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;
use Netauratech\CoreCms\Contracts\ContentProviderInterface;
use Netauratech\CoreCms\Models\Option;

class PageController extends Controller
{
    /**
     * @var ContentProviderInterface
     */
    protected ContentProviderInterface $contentProvider;

    public function __construct(ContentProviderInterface $contentProvider)
    {
        $this->contentProvider = $contentProvider;
    }

    /**
     * Displays the site's home page.
     * The page is determined by the ‘homepage’ option.
     *
     * @return View
     */
    public function homepage(): View
    {
        $homepageOption = Option::where('key', 'homepage')->first();
        $homepageContentId = $homepageOption ? $homepageOption->value : null;

        $page = null;
        if ($homepageContentId) {
            $page = $this->contentProvider->getContentById((int) $homepageContentId);
        }

        if (!$page) {
            abort(404, 'Page d\'accueil non configurée ou introuvable.');
        }

        return view('content-manager::front.page', [
            'page' => $page,
            'isHomepage' => true,
        ]);
    }

    /**
     * Displays a specific page by its slug.
     *
     * @param string $slug The slug of the page.
     * @return View
     */
    public function show(string $slug): View
    {
        $page = $this->contentProvider->getContentBySlug($slug);

        if (!$page || $page->type !== 'page' || $page->status !== 'published') {
            abort(404, 'Page introuvable ou non publiée.');
        }

        return view('content-manager::front.page', [
            'page' => $page,
            'isHomepage' => false,
        ]);
    }
}