<?php

namespace App\Orchid\Filters\Design;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

class DesignCategoryFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Категории дизайна';
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
                ->title('ID категории дизайна')
                ->placeholder('1')
                ->type('number')
                ->value($this->request->get('filter[id]')),

            Input::make('filter[name]')
                ->title('Название')
                ->placeholder('stickers..')
                ->value($this->request->get('filter[name]')),
        ];
    }
}
