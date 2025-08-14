@extends('core-cms::base')

@section('stylesheets')
    @includeIf('theme::assets.admin.css')
    <style>
        {{ $css }}
    </style>
@overwrite

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

@section('body')
    <div id="ve-components">
        @foreach($blocks as $block)
            @includeIf('content-manager::shared.blocks.renderer', ['bloc' => $block, 'css' => null])
        @endforeach
    </div>
@overwrite
