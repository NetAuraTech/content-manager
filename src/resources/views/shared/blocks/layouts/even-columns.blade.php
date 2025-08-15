@extends('content-manager::shared.blocks.components.base')

@section('content')
    @if(key_exists('title', $block) && $block['title'] !== "")
        @include('content-manager::shared.blocks.components.title', ['block' => $block])
    @endif
    <div class="even-columns">
        @foreach($block['layout-items'] as $item)
            @includeIf('content-manager::shared.blocks.renderer', ['block' => $item, 'key' => 'item-type', 'props' => ['useContainer' => false, 'section' => 'div']])
        @endforeach
    </div>
@overwrite
