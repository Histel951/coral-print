<?php

namespace App\Orchid\Filters\Material;

use App\Models\Material;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;

class MaterialTypeSubFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Подтипы материалов';
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
                ->title('ID подтипа')
                ->placeholder('7')
                ->type('number'),

            Input::make('filter[name]')
                ->value($this->request->get('filter[name]'))
                ->title('Название')
                ->placeholder('Maestro print 80..'),

            Input::make('filter[cost_price]')
                ->value($this->request->get('filter[cost_price]'))
                ->title('Себестоимость')
                ->placeholder('14.88')
                ->step('0.01')
                ->type('number'),

            Input::make('filter[price]')
                ->value($this->request->get('filter[price]'))
                ->placeholder('6.62')
                ->step('0.01')
                ->type('number')
                ->title('Цена'),

            Input::make('filter[sequence]')
                ->value($this->request->get('filter[sequence]'))
                ->placeholder('48')
                ->type('number')
                ->title('Последовательность'),

            Relation::make('filter[material_id]')
                ->title('Материал')
                ->value($this->request->get('filter[material_id]'))
                ->fromModel(Material::class, 'name', 'id'),

            Input::make('filter[color]')
                ->value($this->request->get('filter[color]'))
                ->title('Цвет')
                ->placeholder('#FFFFFF'),

            CheckBox::make('filter[hex]')
                ->checked((bool) $this->request->get('filter[hex]'))
                ->title('Хекс цвет'),
        ];
    }
}
