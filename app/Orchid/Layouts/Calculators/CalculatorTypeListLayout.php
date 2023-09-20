<?php

namespace App\Orchid\Layouts\Calculators;

use App\Models\CalculatorType;
use App\Orchid\Custom\CustomTD;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CalculatorTypeListLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'calculator_types';

    protected string $editRoute = 'platform.calculator.type.edit';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('name', 'Название'),

            TD::make('calculators_route', 'Калькуляторы')
                ->alignCenter()
                ->width(30)
                ->render(function (CalculatorType $calculatorType) {
                    return Link::make('перейти ')
                        ->icon('arrow-right')
                        ->route('platform.calculators', [
                            'filter[calculator_type_id]' => $calculatorType->id,
                        ]);
                }),

            TD::make('previews_route', 'Превью')
                ->alignCenter()
                ->width(30)
                ->render(function (CalculatorType $calculatorType) {
                    return Link::make('перейти ')
                        ->icon('arrow-right')
                        ->route('platform.previews', [
                            'filter[calculator_type_id]' => $calculatorType->id,
                        ]);
                }),

            TD::make('action', 'Действие')->render(function (CalculatorType $calculatorType) {
                return CustomTD::make()->optionButtons('platform.calculator.type.edit', $calculatorType);
            }),
        ];
    }
}
