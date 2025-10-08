@php
    $blocKey = $blocKey ?? 'title';
    $block = $block ?? [];

    $titleClasses = ["margin-block-end-6", "block__" . substr(md5(json_encode($block)), 0, 8) . "-{$blocKey}"];
    $titleStyles = [];

    if(key_exists("{$blocKey}_animation", $block) && $block["{$blocKey}_animation"] !== '') {
        $titleClasses[] = $block["{$blocKey}_animation"];

        if(key_exists("{$blocKey}_delay", $block) && $block["{$blocKey}_delay"] !== "0") {
            $titleStyles[] = '--delay: ' . $block["{$blocKey}_delay"] . 's;';
        }
    }
@endphp

@if(key_exists("{$blocKey}-level", $block) && $block["{$blocKey}-level"] === 'h1')
    @php
        $titleClasses[] = 'heading-1'
    @endphp
    <h1
        class="{{ join(" ", $titleClasses) }}"
        @if(count($titleStyles) > 0)style="{{ implode(";", $titleStyles) }}"@endif
    >
        {{ $block[$blocKey] }}
    </h1>
@elseif(key_exists("{$blocKey}-level", $block) && $block["{$blocKey}-level"] === 'h2')
    @php
        $titleClasses[] = 'heading-2'
    @endphp
    <h2
        class="{{ join(" ", $titleClasses) }}"
        @if(count($titleStyles) > 0)style="{{ implode(";", $titleStyles) }}"@endif
    >
        {{ $block[$blocKey] }}
    </h2>
@elseif(key_exists("{$blocKey}-level", $block) && $block["{$blocKey}-level"] === 'h3')
    @php
        $titleClasses[] = 'heading-3'
    @endphp
    <h3
        class="{{ join(" ", $titleClasses) }}"
        @if(count($titleStyles) > 0)style="{{ implode(";", $titleStyles) }}"@endif
    >
        {{ $block[$blocKey] }}
    </h3>
@elseif(key_exists("{$blocKey}-level", $block) && $block["{$blocKey}-level"] === 'h4')
    @php
        $titleClasses[] = 'heading-4'
    @endphp
    <h4
        class="{{ join(" ", $titleClasses) }}"
        @if(count($titleStyles) > 0)style="{{ implode(";", $titleStyles) }}"@endif
    >
        {{ $block[$blocKey] }}
    </h4>
@else
    @php
        $titleClasses[] = 'heading-5'
    @endphp
    <h5
        class="{{ join(" ", $titleClasses) }}"
        @if(count($titleStyles) > 0)style="{{ implode(";", $titleStyles) }}"@endif
    >
        {{ $block[$blocKey] }}
    </h5>
@endif
