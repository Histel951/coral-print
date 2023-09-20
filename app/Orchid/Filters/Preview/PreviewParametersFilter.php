<?php

namespace App\Orchid\Filters\Preview;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;

class PreviewParametersFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'параметры';
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
            CheckBox::make('filter[is_volume]')
                ->title('Объёмное')
                ->value((bool) (int) $this->request->input('filter.is_volume', false))
                ->sendTrueOrFalse(),

            CheckBox::make('filter[is_mounting_film]')
                ->title('Монтажная плёнка')
                ->value((bool) (int) $this->request->input('filter.is_mounting_film', false))
                ->sendTrueOrFalse(),

            Input::make('filter[id]')
                ->value($this->request->input('filter.id'))
                ->title('ID')
                ->type('number')
                ->placeholder('3815'),
        ];
    }
}
