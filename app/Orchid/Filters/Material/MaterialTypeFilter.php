<?php

namespace App\Orchid\Filters\Material;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

class MaterialTypeFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Тим материала';
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
                ->type('number')
                ->placeholder('4'),

            Input::make('filter[name]')
                ->value($this->request->get('filter[name]'))
                ->placeholder('thermal_labels..'),

            Input::make('filter[type_name]')
                ->value($this->request->get('filter[type_name]'))
                ->placeholder('Термоэтикетки..'),

            Input::make('filter[sort]')
                ->value($this->request->get('filter[sort]'))
                ->placeholder('100')
                ->type('number'),

            Input::make('filter[sequence]')
                ->value($this->request->get('filter[sequence]'))
                ->placeholder('0')
                ->type('number'),
        ];
    }
}
