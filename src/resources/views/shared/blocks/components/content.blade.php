@php
    $block = $block ?? [];

    $contentClasses = $contentClasses ?? [];
    $contentClasses[] = 'block__' . substr(md5(json_encode($block)), 0, 8) . '-content';

    if(key_exists('content_animation', $block) && $block['content_animation'] !== '') {
        $contentClasses[] = $block['content_animation'];
    }
@endphp

<div
    class="{{ join(" ", $contentClasses) }}"
>
    @shortcode($block['content'], ['content' => $content ?? ''])
</div>
