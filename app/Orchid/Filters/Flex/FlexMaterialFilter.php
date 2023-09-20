<?php

namespace App\Orchid\Filters\Flex;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;

class FlexMaterialFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Материалы флексы';
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
                ->value($this->request->get('filter[id]'))
                ->title('ID')
                ->type('number')
                ->placeholder('3815'),

            Input::make('filter[name]')
                ->value($this->request->get('filter[name]'))
                ->title('Название')
                ->placeholder('Круглые с..'),

            Input::make('filter[article]')
                ->value($this->request->get('filter[article]'))
                ->title('Артикул')
                ->placeholder('H907 62Dps..'),

            Input::make('filter[min_meters]')
                ->value($this->request->get('filter[min_meters]'))
                ->title('Минимум метров')
                ->type('number')
                ->placeholder('100'),

            Input::make('filter[weight]')
                ->value($this->request->get('filter[weight]'))
                ->title('Масса')
                ->type('number')
                ->placeholder('135'),

            Input::make('filter[price]')
                ->value($this->request->get('filter[price]'))
                ->title('Цена')
                ->step('0.001')
                ->type('number')
                ->placeholder('0.672'),

            Input::make('filter[price]')
                ->value($this->request->get('filter[price]'))
                ->title('Процент наценки')
                ->type('number')
                ->placeholder('70'),

            CheckBox::make('filter[show]')
                ->title('Показывать')
                ->checked((bool) $this->request->get('filter[show]'))
                ->sendTrueOrFalse(),

            Input::make('filter[sequence]')
                ->value($this->request->get('filter[sequence]'))
                ->title('Порядок')
                ->type('number')
                ->placeholder('31'),

            Input::make('filter[volume]')
                ->value($this->request->get('filter[volume]'))
                ->title('Объём')
                ->type('number')
                ->placeholder('130'),
        ];
    }
}
