<?php

namespace App\Orchid\Layouts;

use App\Models\CalculatorType;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;

class GalleryCategoriesListTable extends StandardTable
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
            TD::make('name', 'Название')->alignLeft(),

            TD::make('calculators_route', 'Калькуляторы')
                ->alignLeft()
                ->render(function (CalculatorType $calculatorType) {
                    return Link::make('перейти ')
                        ->icon('arrow-right')
                        ->route('platform.gallery', $calculatorType);
                }),
        ];
    }
}
