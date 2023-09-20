<?php

namespace App\Orchid\Layouts\Design;

use App\Models\Design;
use App\Orchid\Custom\CustomTD;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;

class DesignListLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'designs';

    protected string $editRoute = 'platform.design.edit';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('name', 'Название'),

            TD::make('calculator_type.name', 'Тип калькулятора')->render(function (Design $design) {
                return Link::make($design->calculatorType->name)->route(
                    'platform.calculator.type.edit',
                    $design->calculatorType,
                );
            }),

            TD::make('materials', 'База')
                ->width(30)
                ->alignCenter()
                ->render(
                    fn (Design $design) => Link::make('перейти')
                        ->icon('arrow-right')
                        ->route('platform.design.prices', [
                            'filter[design_id]' => $design->id,
                        ]),
                ),

            TD::make('action', 'Действие')->render(function (Design $design) {
                return CustomTD::make()->optionButtons('platform.design.edit', $design);
            }),
        ];
    }
}
