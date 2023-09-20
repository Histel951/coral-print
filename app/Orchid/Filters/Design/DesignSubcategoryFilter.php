<?php

namespace App\Orchid\Filters\Design;

use App\Models\DesignCategory;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;

class DesignSubcategoryFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Подкатегории дизайна';
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
                ->title('ID подкатегории')
                ->type('number')
                ->placeholder('1')
                ->value($this->request->get('filter[id]')),

            Input::make('filter[name]')
                ->title('Название')
                ->placeholder('stickers..')
                ->value($this->request->get('filter[name]')),

            Relation::make('filter[design_category_id]')
                ->value($this->request->get('filter[design_category_id]'))
                ->title('Категория дизайна')
                ->fromModel(DesignCategory::class, 'name', 'id'),
        ];
    }
}
