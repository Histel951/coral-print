<?php

namespace App\Orchid\Filters\Work;

use App\Models\WorkAdditional;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;

class WorkAdditionalPriceFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Доп. работы';
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
                ->title('ID')
                ->type('number')
                ->placeholder('179')
                ->value($this->request->get('filter[id]')),

            Input::make('filter[list_meters]')
                ->title('Длина листа (???)')
                ->type('number')
                ->placeholder('0')
                ->value($this->request->get('filter[list_meters]')),

            CheckBox::make('filter[circulation]')
                ->title('Обращение')
                ->sendTrueOrFalse()
                ->checked((bool) $this->request->get('filter[circulation]')),

            Input::make('filter[price]')
                ->title('Цена')
                ->type('number')
                ->placeholder('160')
                ->value($this->request->get('filter[price]')),

            Input::make('filter[fixed_sum]')
                ->title('Фиксированная сумма')
                ->placeholder('1620')
                ->type('number')
                ->value($this->request->get('filter[fixed_sum]')),

            Input::make('filter[percent]')
                ->type('number')
                ->placeholder('50')
                ->title('Процент')
                ->value($this->request->get('filter[percent]')),

            Input::make('filter[charge]')
                ->type('number')
                ->placeholder('100')
                ->title('charge')
                ->value($this->request->get('filter[charge]')),

            Relation::make('filter[work_additional_id]')
                ->title('Доп. работа')
                ->value($this->request->get('flter[work_additional_id]'))
                ->fromModel(WorkAdditional::class, 'name', 'id'),
        ];
    }
}
