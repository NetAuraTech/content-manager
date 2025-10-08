@php
    $blocKey = $blocKey ?? 'content';
    $block = $block ?? [];

    $contentClasses = $contentClasses ?? [];
    $contentClasses[] = "block__" . substr(md5(json_encode($block)), 0, 8) . "-{$blocKey}";

    $contentStyles = [];

    if(key_exists("{$blocKey}_animation", $block) && $block["{$blocKey}_animation"] !== '') {
        $contentClasses[] = $block["{$blocKey}_animation"];

        if(key_exists("{$blocKey}_delay", $block) && $block["{$blocKey}_delay"] !== "0") {
            $contentStyles[] = '--delay: ' . $block["{$blocKey}_delay"] . 's;';
        }
    }
@endphp

<div
    class="{{ join(" ", $contentClasses) }}"
    @if(count($contentStyles) > 0)style="{{ implode(";", $contentStyles) }}"@endif
>
    @shortcode($block['content'], ['content' => $content ?? '', 'options' => $options ?? []])
</div>
