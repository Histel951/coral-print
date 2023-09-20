<?php

namespace App\Orchid\Filters\Design;

use App\Models\Design;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;

class DesignPriceFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Цена дизайна';
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
                ->type('number')
                ->placeholder('3')
                ->title('ID цены дизайна')
                ->value($this->request->get('filter[id]')),

            Input::make('filter[name]')
                ->placeholder('Услуга..')
                ->title('Название')
                ->value($this->request->get('filter[name]')),

            Input::make('filter[value]')
                ->placeholder('90')
                ->title('Цена')
                ->value($this->request->get('filter[value]')),

            Relation::make('filter[design_id]')
                ->title('Дизайн')
                ->value($this->request->get('filter[design_id]'))
                ->fromModel(Design::class, 'name', 'id'),
        ];
    }
}
