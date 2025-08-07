@extends('core-cms::base')

@section('stylesheets')
    @includeIf('theme::assets.admin.css')
    <style>
        {{ $css }}
    </style>
@overwrite

@section('body')
    <div id="ve-components">
        @foreach($blocks as $block)
            @includeIf('content-manager::shared.blocks.renderer', ['bloc' => $block, 'css' => null])
        @endforeach
    </div>
@overwrite
