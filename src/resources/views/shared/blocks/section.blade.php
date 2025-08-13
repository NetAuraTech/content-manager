@extends('content-manager::shared.blocks.layouts.layout')

@php
    $block = $block ??  [];
    $useContainer = $useContainer ?? $block['use-container'] ?? true;
    $section = $section ?? 'section';
    $classes = ['section'];
@endphp


@section('class')
    {{ join(' ', $classes) }}
@overwrite

@section('element')
    {{$section}}
@overwrite

@section('content')
    @php
        $sectionClasses = [];

        if($useContainer) {
            $sectionClasses[] = 'container';
        }

        $transitionName = null;
        if (key_exists('image-transition-name', $block) && $block['image-transition-name'] !== "") {
            $transitionName = $block['image-transition-name'];
        }
    @endphp
    <div class="{{ join(" ", $sectionClasses) }}">
        @if(key_exists('image', $block) && $block['image'] !== "")
            <div class="margin-block-end-6 text-center">
                {!! image_tag($block['image'], key_exists('image-alt', $block) ? $block['image-alt'] : null, $block['image-height'] ?: null, $transitionName, 'block__' . substr(md5(json_encode($block)), 0, 8) . '-img') !!}
            </div>
        @endif
        @if(key_exists('title', $block)  && $block['title'] !== "")
            @include('content-manager::shared.blocks.components.title', ['block' => $block])
        @endif
        @if(key_exists('content', $block)  && $block['content'] !== "")
            @include('content-manager::shared.blocks.components.content', ['block' => $block])
        @endif
        @if(key_exists('ctas', $block) && count($block['ctas']) > 0)
            <div class="flex-group align-items-center margin-block-start-4">
                @foreach($block['ctas'] as $cta)
                    @include('content-manager::shared.blocks.components.cta', ['block' => $cta])
                @endforeach
            </div>
        @endif
    </div>
@overwrite
