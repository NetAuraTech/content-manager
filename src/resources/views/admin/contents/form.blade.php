@extends('core-cms::admin.base')

@section('title')
    @if($content->exists)
        {{ __('core-cms::admin.edit') }} {{ trans_choice('content-manager::admin.content.' . $contentType . '.value', 1) }}
    @else
        {{ __('core-cms::admin.create') }} {{ trans_choice('content-manager::admin.content.' . $contentType . '.value', 1) }}
    @endif
@endsection

@section('body')
    <section class="grid">
        <h2 class="heading-2 flex-group align-items-center">
            @php
                switch ($contentType) {
                    case 'template':
                    case 'header':
                    case 'footer':
                        $icon = 'template';
                        break;
                    default:
                        $icon = $contentType;
                        break;
                }
            @endphp
            {!! icon($icon, 'small') !!}
            @if($content->exists)
                {{ __('core-cms::admin.edit') }} {{ trans_choice('content-manager::admin.content.' . $contentType . '.value', 1) }}
            @else
                {{ __('core-cms::admin.create') }} {{ trans_choice('content-manager::admin.content.' . $contentType . '.value', 1) }}
            @endif
        </h2>
        <div class="card">
            <form class="grid"
                  action="{{ route($content->exists ? 'admin.contents.update' : 'admin.contents.store', $content->exists ? $content : ['type' => $contentType]) }}"
                  method="POST">
                @csrf
                @method($content->exists ? 'put' : 'post')
                <div class="grid">
                    @include('core-cms::shared.input', ['label' => __('content-manager::admin.content.title'), 'name' => 'title', 'value' => $content->title])
                    @include('core-cms::shared.input', ['label' => __('content-manager::admin.content.slug'), 'name' => 'slug', 'value' => $content->slug])
                    @include('core-cms::shared.input', ['label' => __('content-manager::admin.content.description'), 'name' => 'description', 'value' => $content->description, 'type' => 'textarea'])
                    <editor-builder
                            id="content"
                            name="content"
                            value="{{ $content->content ?: '[]' }}"
                            preview="{{ route('admin.contents.preview', ['type' => $content->type]) }}"
                    ></editor-builder>
                    @if(in_array($contentType, ['template', 'header', 'footer']))
                        @include('core-cms::shared.select', [
                            'label' => __('content-manager::admin.content.type.value'),
                            'name' => 'type',
                            'value' => old('type', $content->type),
                            'selectOptions' => [
                                (object)['key' => 'header', 'label' => __('content-manager::admin.content.type.header')],
                                (object)['key' => 'footer', 'label' => __('content-manager::admin.content.type.footer')],
                            ],
                        ])
                    @else
                        <input type="hidden" name="type" value="{{ $contentType }}">
                    @endif
                    @include('core-cms::shared.select', [
                        'label' => __('content-manager::admin.content.status.value'),
                        'name' => 'status',
                        'value' => old('status', $content->status),
                        'selectOptions' => [
                            (object)['key' => 'draft', 'label' => __('content-manager::admin.content.status.draft')],
                            (object)['key' => 'published', 'label' => __('content-manager::admin.content.status.published')],
                            (object)['key' => 'archived', 'label' => __('content-manager::admin.content.status.archived')],
                        ]
                    ])
                    @include('core-cms::shared.input', ['label' => __('content-manager::admin.content.published_at'), 'name' => 'published_at', 'value' => $content->published_at?->format('Y-m-d H:i:s'), 'type' => 'datepicker'])
                    <div class="text-center">
                        <button type="submit" class="button" data-type="primary">{{ __('core-cms::admin.save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection