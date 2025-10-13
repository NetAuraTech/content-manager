@extends('content-manager::shared.blocks.layouts.layout')

@php
    $block = $block ??  [];
    $useContainer = $useContainer ?? $block['use-container'] ?? true;
    $section = $section ?? 'section';
    $classes = ['automatic-gallery'];
@endphp


@section('class')
    {{ join(' ', $classes) }}
@overwrite

@section('element')
    {{$section}}
@overwrite

@section('content')
    @php
        $gridClasses = [];

        if($useContainer) {
            $gridClasses[] = 'container';
        }
    @endphp
    <div class="{{ join(" ", $gridClasses) }}">
        @if(key_exists('title', $block)  && $block['title'] !== "")
            @include('content-manager::shared.blocks.components.title', ['block' => $block])
        @endif
        @if(key_exists('content', $block)  && $block['content'] !== "")
            @include('content-manager::shared.blocks.components.content', ['block' => $block])
        @endif
        @if(key_exists('row-height', $block))
            <light-box>
                <automatic-gallery gap="{{ $block['gap'] }}rem" rowHeight="{{ $block['row-height'] }}">
                    @if(key_exists('medias', $block))
                        <div class="margin-block-start-10">
                            @foreach($block['medias'] as $item)
                                @if(key_exists('media', $item) && $item['media'] != "")
                                    <a href="{{ image_url($item['media']) }}">
                                        {!! image_tag($item['media'], key_exists('media-alt', $item) ? $item['media-alt'] : null, $block['row-height']) !!}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </automatic-gallery>
            </light-box>
        @endif
    </div>
@overwrite
