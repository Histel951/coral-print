@foreach($data as $blocks)
    @foreach ($blocks as $block)
        @include('partials.pageBuilder.blocks.' . $block['block_id'], ['data' => $block, 'documentObject' => $documentObject])
    @endforeach
@endforeach