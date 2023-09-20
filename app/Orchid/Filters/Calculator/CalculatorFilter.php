<?php

namespace App\Orchid\Filters\Calculator;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;

class CalculatorFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Калькулятор';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder;
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Input::make('filter[id]')
                ->value($this->request->input('filter.id'))
                ->title('ID')
                ->type('number')
                ->placeholder('3815'),

            Input::make('filter[name]')
                ->value($this->request->input('filter.name'))
                ->title('Название')
                ->placeholder('Круглые с..'),

            Input::make('filter[min_price]')
                ->type('number')
                ->title('Минимальная цена')
                ->value($this->request->input('filter.min_price'))
                ->placeholder('30'),

            CheckBox::make('filter[active]')
                ->value((bool) $this->request->input('filter.active'))
                ->title('Активность')
                ->sendTrueOrFalse(),
        ];
    }
}
