@extends('content-manager::shared.blocks.layouts.layout')

@php
    $block = $block ??  [];
    $useContainer = $useContainer ?? $block['use-container'] ?? true;
    $section = $section ?? 'section';
    $classes = ['contact'];
@endphp


@section('class')
    {{ join(' ', $classes) }}
@overwrite

@section('element')
    {{$section}}
@overwrite

@section('content')
    @php
        $contactClasses = [];

        if($useContainer) {
            $contactClasses[] = 'container';
        }
    @endphp
    <div class="{{ join(" ", $contactClasses) }}">
        @if(key_exists('title', $block)  && $block['title'] !== "")
            @include('content-manager::shared.blocks.components.title', ['block' => $block])
        @endif
        @if(key_exists('content', $block)  && $block['content'] !== "")
                @include('content-manager::shared.blocks.components.content', ['block' => $block])
        @endif
        <div class="card margin-block-start-6">
            @include('core-cms::shared.partials.flash', ['floating' => false, 'duration' => 10])
            <form
                class="grid"
                method="post"
                action="{{ route('contact') }}"
            >
                @csrf
                <div class="grid-auto-fit align-items-center" style="width: initial;">
                    @include('core-cms::shared.input', ['label' => __('cms.lastname'), 'name' => 'lastname',])
                    @include('core-cms::shared.input', ['label' => __('cms.firstname'), 'name' => 'firstname',])
                </div>
                <div class="grid-auto-fit align-items-center" style="width: initial;">
                    @include('core-cms::shared.input', ['label' => __('cms.email'), 'name' => 'email', 'type' => 'email',])
                    @include('core-cms::shared.input', ['label' => __('cms.phone'), 'name' => 'phone'])
                </div>
                @php
                    $subjects = collect([]);

                    if (array_key_exists('subjects', $block)) {
                        $subjects = collect($block['subjects']);
                    }

                @endphp
                @include('core-cms::shared.select', ['label' => __('cms.subject'), 'name' => 'subject', 'selectOptions' => $subjects->map(fn($s) => (object)['key' => $s['option'],'label' => $s['option']])])
                @include('core-cms::shared.input', ['label' => __('cms.message'), 'name' => 'content', 'type' => 'textarea'])
                @include('core-cms::shared.captcha', ['label' => __('cms.captcha.value'), 'name' => 'captcha'])

                <div class="flex-group">
                    <button
                        class="button"
                        data-type="primary"
                        type="submit"
                    >
                        {{ __('admin.send') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@overwrite
