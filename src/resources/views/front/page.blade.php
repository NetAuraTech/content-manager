@extends('core-cms::base')

@section('title', $content->title)

@section('description')
    <meta property='og:description' content="{{ ($isHomepage ?? false) ? ($options['description'] ?? '') : ($content->description ?? '') }}"/>
    <meta name='twitter:description' content="{{ ($isHomepage ?? false) ? ($options['description'] ?? '') : ($content->description ?? '') }}"/>
    <meta name="description" content="{{ ($isHomepage ?? false) ? ($options['description'] ?? '') : ($content->description ?? '') }}"/>
@endsection

@section('meta')
    @foreach($metas as $meta)
        @include($meta['template'], ['content' => $content, 'openGraphLogo' => $openGraphLogo])
    @endforeach
@endsection

@section('header')
    @if($options['header'] !== "")
        @foreach($options['header']->getContent() as $block)
            @includeIf('content-manager::shared.blocks.renderer', ['block' => $block])
        @endforeach
    @endif
@endsection

@section('footer')
    @if($options['footer'] !== "")
        @foreach($options['footer']->getContent() as $block)
            @includeIf('content-manager::shared.blocks.renderer', ['block' => $block])
        @endforeach
    @endif
@endsection

@section('stylesheets')
    @php
        $contents = [$content, $options['header'], $options['footer']];
    @endphp
    @foreach($contents as $item)
        @php
            $cacheBuster = substr(md5(json_encode($item->updated_at)), 0, 8);
            $cssPath = 'css/' . $item->slug . '.css';
        @endphp
        <link rel="preload" href="{{ route('assets.show', ['path' => $cssPath]) }}?v={{ $cacheBuster }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript>
            <link rel="stylesheet" href="{{ route('assets.show', ['path' => $cssPath]) }}?v={{ $cacheBuster }}">
        </noscript>
    @endforeach
@overwrite

@section('body')
    @foreach($content->getContent() as $block)
        @includeIf('content-manager::shared.blocks.renderer', ['block' => $block, 'content' => $content])
    @endforeach
@endsection