@extends('core-cms::base')

@section('title', $page->title)

@section('description')
    <meta property='og:description' content="{{ ($isHomepage ?? false) ? ($options['description'] ?? '') : ($page->description ?? '') }}"/>
    <meta name='twitter:description' content="{{ ($isHomepage ?? false) ? ($options['description'] ?? '') : ($page->description ?? '') }}"/>
    <meta name="description" content="{{ ($isHomepage ?? false) ? ($options['description'] ?? '') : ($page->description ?? '') }}"/>
@endsection

@section('body')
    {!! $page->content !!}
@endsection