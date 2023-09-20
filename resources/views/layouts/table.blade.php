@empty(!$title)
    <fieldset>
        <div class="col p-0 px-3">
            <legend class="text-black text-black mt-2 mx-2">
                {{ $title }}
            </legend>
        </div>
    </fieldset>
@endempty

<div class="bg-white rounded shadow-sm mb-3"
     data-controller="table"
     data-table-slug="{{$slug}}"
>

    <div class="table-responsive">
        @if(isset($addItemRequestData) && $isAddRowUp)
            <div>
                {!! \App\Orchid\Actions\TurboButton::make('+ Добавить ряд')
                    ->method($addItemRequestData['method'], $addItemRequestData['data'] ?? [])
                    ->id('add-new-item')
                    ->toHtml() !!}
            </div>
        @endif
        <table @class([
                    'table',
                    'table-compact'  => $compact,
                    'table-striped'  => $striped,
                    'table-bordered' => $bordered,
                    'table-hover'    => $hoverable,
               ])>
            <thead>
            <tr>
                @foreach($columns as $column)
                    {!! $column->buildTh() !!}
                @endforeach
            </tr>
            </thead>
            <tbody id="{{ $tBodyId }}">

            @foreach($rows as $source)
                {!! view('orchid.partials.table-tr-item', ['source' => $source, 'columns' => $columns, 'trItemId' => $trItemId]) !!}
            @endforeach

            @if($total->isNotEmpty())
                <tr>
                    @foreach($total as $column)
                        {!! $column->buildTd($repository, $loop) !!}
                    @endforeach
                </tr>
            @endif

            </tbody>
        </table>

        @if(isset($addItemRequestData) && !$isAddRowUp)
            <div>
                {!! \App\Orchid\Actions\TurboButton::make('+ Добавить ряд')
                    ->method($addItemRequestData['method'], $addItemRequestData['data'] ?? [])
                    ->id('add-new-item')
                    ->toHtml() !!}
            </div>
        @endif

    </div>

    @if($rows->isEmpty())
        <div class="text-center py-5 w-100">
            <h3 class="fw-light">
                @isset($iconNotFound)
                    <x-orchid-icon :path="$iconNotFound" class="block m-b"/>
                @endisset

                {!!  $textNotFound !!}
            </h3>

            {!! $subNotFound !!}
        </div>
    @else

        @include('platform::layouts.pagination',[
                'paginator' => $rows,
                'columns' => $columns,
                'onEachSide' => $onEachSide,
        ])

    @endif
</div>


