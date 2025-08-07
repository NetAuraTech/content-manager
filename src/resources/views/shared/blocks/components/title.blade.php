@php
    $block = $block ?? [];

    $titleClasses = ['margin-block-end-6', 'block__' . substr(md5(json_encode($block)), 0, 8) . '-title'];

    if(key_exists('title_animation', $block) && $block['title_animation'] !== '') {
        $titleClasses[] = $block['title_animation'];
    }
@endphp

@if(key_exists('title-level', $block) && $block['title-level'] === 'h1')
    @php
        $titleClasses[] = 'heading-1'
    @endphp
    <h1
        class="{{ join(" ", $titleClasses) }}"
    >
        {{ $block['title'] }}
    </h1>
@elseif(key_exists('title-level', $block) && $block['title-level'] === 'h2')
    @php
        $titleClasses[] = 'heading-2'
    @endphp
    <h2
        class="{{ join(" ", $titleClasses) }}"
    >
        {{ $block['title'] }}
    </h2>
@elseif(key_exists('title-level', $block) && $block['title-level'] === 'h3')
    @php
        $titleClasses[] = 'heading-3'
    @endphp
    <h3
        class="{{ join(" ", $titleClasses) }}"
    >
        {{ $block['title'] }}
    </h3>
@elseif(key_exists('title-level', $block) && $block['title-level'] === 'h4')
    @php
        $titleClasses[] = 'heading-4'
    @endphp
    <h4
        class="{{ join(" ", $titleClasses) }}"
    >
        {{ $block['title'] }}
    </h4>
@else
    @php
        $titleClasses[] = 'heading-5'
    @endphp
    <h5
        class="{{ join(" ", $titleClasses) }}"
    >
        {{ $block['title'] }}
    </h5>
@endif
