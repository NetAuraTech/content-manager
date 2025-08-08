@extends('core-cms::base')

@section('title', $page->title)

@section('description')
    <meta property='og:description' content="{{ ($isHomepage ?? false) ? ($options['description'] ?? '') : ($page->description ?? '') }}"/>
    <meta name='twitter:description' content="{{ ($isHomepage ?? false) ? ($options['description'] ?? '') : ($page->description ?? '') }}"/>
    <meta name="description" content="{{ ($isHomepage ?? false) ? ($options['description'] ?? '') : ($page->description ?? '') }}"/>
@endsection

@section('stylesheets')
    @php
        $cacheBuster = substr(md5(json_encode($page->updated_at)), 0, 8);
        $cssPath = 'css/' . $page->slug . '.css';
    @endphp
    <link rel="preload" href="{{ route('assets.show', ['path' => $cssPath]) }}?v={{ $cacheBuster }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="{{ route('assets.show', ['path' => $cssPath]) }}?v={{ $cacheBuster }}">
    </noscript>
@overwrite

@section('body')
    @foreach($page->getContent() as $block)
        @includeIf('content-manager::shared.blocks.renderer', ['block' => $block, 'content' => $page])
    @endforeach
@endsection