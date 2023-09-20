<?php

namespace App\Orchid\Filters\Print;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;

class PrintSpeciesFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'разновидости печати';
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
                ->title('ID разновидностей печати')
                ->placeholder('25')
                ->value($this->request->get('filter[id]')),

            Input::make('filter[name]')
                ->title('Название')
                ->placeholder('Струйная..')
                ->value($this->request->get('filter[name]')),

            CheckBox::make('filter[volume]')
                ->title('Объём')
                ->value((bool) $this->request->get('filter[volume]'))
                ->sendTrueOrFalse(),
        ];
    }
}
