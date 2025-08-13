@extends('content-manager::shared.blocks.layouts.layout')

@php
    $block = $block ??  [];
    $useContainer = $useContainer ?? $block['use-container'] ?? true;
    $section = $section ?? 'section';
    $classes = ['image', $block['additional-classes'] ?? ""];
@endphp


@section('class')
    {{ join(' ', $classes) }}
@overwrite

@section('element')
    {{$section}}
@overwrite

@section('content')
    @php
        $imageClasses = [];

        if($useContainer) {
            $imageClasses[] = 'container';
        }
    @endphp
    <div class="{{ join(" ", $imageClasses) }}">
        @if(key_exists('image', $block))
            {!! image_tag($block['image'], key_exists('image-alt', $block) ? $block['image-alt'] : null, $block['image-height'] ?: null, null, 'block__' . substr(md5(json_encode($block)), 0, 8) . '-img') !!}
        @endif
    </div>
@overwrite
