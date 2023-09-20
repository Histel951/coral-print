<?php

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Fields\Input;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ColorPaintFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Краски';
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
     * @return iterable
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function display(): iterable
    {
        return [
            Input::make('filter[name]')
                ->value($this->request->get('filter[name]'))
                ->title('Название')
                ->placeholder('Cian..'),

            Input::make('filter[consumption]')
                ->value($this->request->get('filter[consumption]'))
                ->type('number')
                ->step('0.001')
                ->min(0)
                ->placeholder('0.002'),

            Input::make('filter[price]')
                ->value($this->request->get('filter[price]'))
                ->type('number')
                ->step('0.01')
                ->min(0)
                ->placeholder('36.43'),

            Input::make('filter[price_percent]')
                ->value($this->request->get('filter[price_percent]'))
                ->type('number')
                ->min(0)
                ->placeholder('70'),
        ];
    }
}
