<?php

namespace App\Orchid\Filters\Pivot;

use App\Models\Calculator;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;

class PivotCalculatorFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Связь калькулятор';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['find-calculator_id', 'find-calculator_name'];
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
        if ($this->request->filled('find-calculator_id')) {
            $builder->where('calculator_id', $this->request->get('find-calculator_id'));
        }

        if ($this->request->filled('find-calculator_name')) {
            $builder->whereRelation(
                relation: 'calculator',
                column: 'name',
                operator: 'like',
                value: "%{$this->request->get('find-calculator_name')}%",
            );
        }

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
            Select::make('find-calculator_id')
                ->title('ID калькулятора')
                ->value($this->request->get('find-calculator_id'))
                ->fromModel(Calculator::class, 'name', 'id')
                ->empty(),

            Input::make('find-calculator_name')
                ->value($this->request->get('find-calculator_name'))
                ->title('Название калькулятора')
                ->placeholder('Круглые наклейки..'),
        ];
    }
}
