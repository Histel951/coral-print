<?php

namespace App\Orchid\Layouts\Print;

use App\Models\PrintModel;
use App\Orchid\Custom\CustomTD;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;

class PrintListLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'prints';

    protected string $editRoute = 'platform.print.edit';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('name', 'Название'),
            TD::make('print_type.name', 'Тип печати')->render(function (PrintModel $printModel) {
                return Link::make($printModel->printType->name)->route(
                    'platform.print.type.edit',
                    $printModel->printType,
                );
            }),

            TD::make('action', 'Действие')->render(function (PrintModel $printModel) {
                return CustomTD::make()->optionButtons('platform.print.edit', $printModel);
            }),
        ];
    }
}
