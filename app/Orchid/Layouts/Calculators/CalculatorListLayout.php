<?php

namespace App\Orchid\Layouts\Calculators;

use App\Models\Calculator;
use App\Orchid\Custom\CustomTD;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\TD;

class CalculatorListLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'calculators';

    protected string $editRoute = 'platform.calculator.edit';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('sequence', 'Порядок')->sort(),
            TD::make('name', 'Название')->sort(),

            TD::make('description', 'Описание'),
            TD::make('image', 'Изображение')->render(function (Calculator $calculator): string {
                return "<img src='{$calculator->image?->url()}'>";
            }),
            TD::make('min_price', 'Минимальная цена')->sort(),
            TD::make('active', 'Активность')->render(function (Calculator $calculator): string {
                return CheckBox::make('active')
                    ->checked((bool) $calculator->active)
                    ->disabled();
            }),

            TD::make('calculator_type', 'Тип калькулятора')
                ->sort()
                ->render(function (Calculator $calculator): string {
                    return $calculator->type?->name ?? '';
                }),

            TD::make('previews_route', 'Превью')
                ->alignCenter()
                ->width(30)
                ->render(function (Calculator $calculator) {
                    return Link::make('перейти ')
                        ->icon('arrow-right')
                        ->route('platform.previews', [
                            'filter[calculator_id]' => $calculator->id,
                        ]);
                }),

            TD::make('action', 'Действие')->render(function (Calculator $calculator) {
                return CustomTD::make()->optionButtons('platform.calculator.edit', $calculator);
            }),
        ];
    }
}
