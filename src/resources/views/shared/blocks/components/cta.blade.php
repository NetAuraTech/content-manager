@php
    $block = $block ?? [];

    if($block['type'] == 'internal' && $block['url'] !== "") {
        $json = json_decode($block['url'], true);
        $path = key_exists('slug', $json) ? route($json['path'], $json['slug']) : route($json['path']);
        $label = $block['label'] !== '' ? $block['label'] :  $json['label'];
    } else {
        $path = $block['url'];
        $label = $block['label'];
    }

    $blockClasses = ['button'];

    if(key_exists('link_animation', $block)) {
        $blockClasses[] = $block['link_animation'];
    }
@endphp

<a
    class="{{ join(" ", $blockClasses) }}"
    data-type="primary" href="{{ $path }}"
    title="{{ $label }}"
>
    {{ $label }}
</a>
