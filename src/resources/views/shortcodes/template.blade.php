@foreach($template->getContent() as $block)
    @includeIf('content-manager::shared.blocks.renderer', ['block' => $block])
@endforeach