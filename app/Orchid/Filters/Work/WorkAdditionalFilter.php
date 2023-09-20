<?php

namespace App\Orchid\Filters\Work;

use App\Models\Formula;
use App\Models\WorkAdditional;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;

class WorkAdditionalFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return '';
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
                ->placeholder('9')
                ->type('number'),

            Relation::make('filter[formula_id]')
                ->title('Формула')
                ->fromModel(Formula::class, 'value', 'id'),

            Input::make('filter[name]')
                ->title('Название')
                ->placeholder('Люверсы..'),

            Input::make('filter[type_name]')
                ->title('Название типа')
                ->placeholder('Lyuversi'),

            Input::make('filter[color]')
                ->placeholder('#fda601')
                ->title('Цвет'),

            Input::make('filter[code]')
                ->placeholder('#люверсы')
                ->title('Тэг'),

            Input::make('filter[weight]')
                ->placeholder('0')
                ->title('Вес')
                ->type('number'),

            Input::make('filter[volume]')
                ->placeholder('0')
                ->title('Объём')
                ->type('number'),

            Input::make('filter[times]')
                ->type('number')
                ->title('Повторения')
                ->placeholder('1'),

            Relation::make('filter[work_additional_type_id]')
                ->title('Доп. работа')
                ->fromModel(WorkAdditional::class, 'name', 'id'),
        ];
    }
}
