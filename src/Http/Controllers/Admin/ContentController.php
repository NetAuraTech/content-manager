<?php

namespace Netauratech\ContentManager\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use JsonException;
use Netauratech\ContentManager\Http\Requests\Admin\ContentFormRequest;
use Netauratech\ContentManager\Models\Content;
use Netauratech\ContentManager\Observers\ContentObserver;
use Netauratech\CoreCms\Form\FormRegistry;
use Netauratech\CoreCms\Http\Controllers\AdminController;

class ContentController extends AdminController
{
    protected array $permissions = [
        'content-list'   => ['index'],
        'content-create' => ['create', 'store'],
        'content-edit'   => ['edit', 'update', 'preview'],
        'content-delete' => ['destroy'],
    ];

    protected FormRegistry $formRegistry;

    public function __construct(FormRegistry $formRegistry)
    {
        parent::__construct();
        $this->formRegistry = $formRegistry;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $type): View
    {
        if ($type === 'template') {
            $contents = Content::whereIn('type', ['header', 'footer'])
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        } else {
            $contents = Content::where('type', $type)
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        }

        return view('content-manager::admin.contents.index', [
            'contents' => $contents,
            'contentType' => $type,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $type): View
    {
        $content = new Content();
        $content->type = $type;
        $content->status = 'draft';
        $content->published_at = new Carbon();

        $formFields = $this->formRegistry->getFormFields('content_form');

        return view('content-manager::admin.contents.form', [
            'content' => $content,
            'contentType' => $type,
            'formFields' => $formFields
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContentFormRequest $request, string $type): RedirectResponse
    {
        $content = new Content();
        $content->status = $request->validated('status', 'draft');
        $content->fill($request->validated());
        $content->save();

        return to_route('admin.contents.index', ['type' => $type])->with('success', __('content-manager::admin.content.created'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Content $content): View
    {
        $formFields = $this->formRegistry->getFormFields('content_form');

        return view('content-manager::admin.contents.form', [
            'content' => $content,
            'contentType' => $content->type,
            'formFields' => $formFields
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContentFormRequest $request, Content $content): RedirectResponse
    {
        $content->status = $request->validated('status', 'draft');
        $content->update($request->validated());

        $type = $content->type;

        if(in_array($type, ['header', 'footer'])) {
            $type = 'template';
        }

        return to_route('admin.contents.index', ['type' => $type])->with('success', __('content-manager::admin.content.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Content $content): RedirectResponse
    {
        $content->delete();

        $type = $content->type;

        if(in_array($type, ['header', 'footer'])) {
            $type = 'template';
        }

        return to_route('admin.contents.index', ['type' => $type])->with('success', __('content-manager::admin.content.deleted'));
    }

    /**
     * Manages previews for content or templates.
     * @throws JsonException
     */
    public function preview(Request $request, string $type = 'content'): View
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $post = new Content();
        $post->id = 9_999_999;
        $post->title = 'Lorem ipsum dolor';
        $post->slug = 'lorem-ipsum-dolor';
        $post->created_at = now();

        $hideHeaderFooter = in_array($type, ['template', 'header', 'footer']);

        $css = "";

        if (array_is_list($data)) {
            foreach ($data as $block) {
                if(!empty($block['layout-items'])) {
                    foreach ($block['layout-items'] as $item) {
                        $css = ContentObserver::generate($item, $css);
                    }
                }

                $css = ContentObserver::generate($block, $css);
            }
            return view('content-manager::admin.contents.preview', [
                'blocks' => $data,
                'content' => $post,
                'css' => $css,
                'hideHeaderFooter' => $hideHeaderFooter,
            ]);
        }

        if(!empty($data['layout-items'])) {
            foreach ($data['layout-items'] as $item) {
                $css = ContentObserver::generate($item, $css);
            }
        }

        $css = ContentObserver::generate($data, $css);

        return view('content-manager::shared.blocks.renderer', [
            'block' => $data,
            'content' => $post,
            'css' => $css,
            'hideHeaderFooter' => $hideHeaderFooter,
        ]);
    }
}
