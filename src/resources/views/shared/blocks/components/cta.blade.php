@php
    $blocKey = $blocKey ?? 'link';
    $block = $block ?? [];

    if($block['type'] == 'internal' && $block['url'] !== "") {
        $json = json_decode($block['url'], true);
        $path = key_exists('slug', $json) ? route($json['path'], $json['slug']) : route($json['path']);
        $label = $block['label'] !== '' ? $block['label'] :  $json['label'];
    } else {
        $path = $block['url'];
        $label = $block['label'];
    }

    $ctaClasses = ['button'];
    $ctaStyles = [];

    if(key_exists("{$blocKey}_animation", $block) && $block["{$blocKey}_animation"] !== '') {
        $ctaClasses[] = $block["{$blocKey}_animation"];

        if(key_exists("{$blocKey}_delay", $block) && $block["{$blocKey}_delay"] !== "0") {
            $ctaStyles[] = '--delay: ' . $block["{$blocKey}_delay"] . 's;';
        }
    }
@endphp

<a
    class="{{ join(" ", $ctaClasses) }}"
    data-type="primary" href="{{ $path }}"
    title="{{ $label }}"
    @if(count($ctaStyles) > 0)style="{{ implode(";", $ctaStyles) }}"@endif
>
    {{ $label }}
</a>
