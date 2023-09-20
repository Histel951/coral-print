<turbo-stream action="{{ $action ?? 'append'}}" target="{{ $target ?? 'table-tbody' }}">
    <template>
        {!! view('orchid.partials.table-tr-item', [
             'source' => $source,
             'columns' => $columns,
             'trItemId' => $trItemId ?? "tr-item-$source->id"
      ]) !!}
    </template>
</turbo-stream>
