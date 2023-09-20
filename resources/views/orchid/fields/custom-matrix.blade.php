@component($typeForm, get_defined_vars())
    <div class="matrix-container">
        <table class="matrix table table-bordered border-right-0"
               data-controller="matrix"
               data-matrix-index="{{ $index }}"
               data-matrix-rows="{{ $maxRows }}"
               data-matrix-key-value="{{ var_export($keyValue) }}"
        >
            <thead>
            <tr>
                @foreach($columns as $key => $column)
                    <th scope="col" class="text-capitalize col-matrix">
                        {{ is_int($key) ? $column : $key }}
                    </th>
                @endforeach

                @if(isset($additional_fields))
                    @foreach($additional_fields as $key => $column)
                        <th scope="col" class="text-capitalize col-matrix">
                            {{ is_int($key) ? $column[1] : $key }}
                        </th>
                    @endforeach
                @endif
            </tr>
            </thead>
            <tbody class="table-body">

            @foreach($value as $key => $row)
                @include('orchid.partials.custom-matrixRow', ['row' => $row, 'key' => $key])
            @endforeach

            @if(isset($additional_fields))
                @foreach($value as $key => $row)

                    <tr class="matrix-item">
                        @foreach($additional_fields as $column)

                            <th class="p-0 align-middle">
                                {!!
                                   $column[0]
                                        ->value($row[$column[1]] ?? '')
                                        ->prefix($name)
                                        ->id("$idPrefix-$key-$column[1]")
                                        ->name($keyValue ? $column : "[$key][$column[1]]")
                                !!}
                            </th>

                            @if ($loop->last && $removableRows)
                                <th class="no-border text-center align-middle">
                                    <a href="#"
                                       data-action="matrix#deleteRow"
                                       class="small text-muted"
                                       title="Remove row">
                                        <x-orchid-icon path="trash"/>
                                    </a>
                                </th>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            @endif

            <tr class="add-row">
                <th colspan="{{ count($columns) }}" class="text-center p-0">
                    <a href="#" data-action="matrix#addRow" class="btn btn-block small text-muted">
                        <x-orchid-icon path="plus-alt"/>

                        <span>{{ __('Add row') }}</span>
                    </a>
                </th>
            </tr>

            <template class="matrix-template">
                @include('orchid.partials.custom-matrixRow', ['row' => [], 'key' => '{index}'])
            </template>
            </tbody>
        </table>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            let paginatePage = 10;
            const allItems = document.querySelectorAll('.table-body > .matrix-item');


        });
    </script>

    <style>
        .table > thead > tr > th {
            padding: 10px;
            text-align: center;
        }

        .table thead tr th:first-child {
            padding: 8px 8px 8px 0;
            text-align: center;
        }

        .matrix-container {
            overflow: scroll;
            overflow-y: hidden;
        }

        /*.col-matrix {*/
        /*    padding: 0;*/
        /*    text-align: center;*/
        /*}*/
    </style>
@endcomponent
