<?php

namespace App\Orchid\Filters\Material;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

class MaterialCategoryFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Категории материалов';
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
                ->title('ID категории')
                ->placeholder('5')
                ->value($this->request->get('filter[id]')),

            Input::make('filter[name]')
                ->title('Название')
                ->placeholder('Стандартные бумаги..')
                ->value($this->request->get('find-material-category_name')),
        ];
    }
}
