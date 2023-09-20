<?php

namespace App\Orchid\Layouts\Print\Type;

use App\Models\PrintType;
use App\Orchid\Custom\CustomTD;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;

class PrintTypeListLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'printTypes';

    protected string $editRoute = 'platform.print.type.edit';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('name', 'Название'),

            TD::make('prints', 'Печати')
                ->alignCenter()
                ->width(30)
                ->render(
                    fn (PrintType $printType) => Link::make('перейти')
                        ->icon('arrow-right')
                        ->route('platform.module.prints', [
                            'filter[print_type_id]' => $printType->id,
                        ]),
                ),

            TD::make('action', 'Действие')->render(function (PrintType $printType) {
                return CustomTD::make()->optionButtons('platform.print.type.edit', $printType);
            }),
        ];
    }
}
