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

@section('stylesheets')
    @php
        $cacheBuster = substr(md5(json_encode($content->updated_at)), 0, 8);
        $cssPath = 'css/' . $content->slug . '.css';
    @endphp
    <link rel="preload" href="{{ route('assets.show', ['path' => $cssPath]) }}?v={{ $cacheBuster }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="{{ route('assets.show', ['path' => $cssPath]) }}?v={{ $cacheBuster }}">
    </noscript>
@overwrite

@section('body')
    @foreach($content->getContent() as $block)
        @includeIf('content-manager::shared.blocks.renderer', ['block' => $block, 'content' => $content])
    @endforeach
@endsection