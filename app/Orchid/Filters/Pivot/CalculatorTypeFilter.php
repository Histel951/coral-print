<?php

namespace App\Orchid\Filters\Pivot;

use App\Models\CalculatorType;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;

class CalculatorTypeFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Связь тип калькулятора';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['find-calculator_calculator-type-id', 'find-calculator_calculator-type-name'];
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
        if ($this->request->filled('find-calculator_calculator-type-id')) {
            $builder->where('calculator_type_id', '=', $this->request->get('find-calculator_calculator-type-id'));
        }

        if ($this->request->filled('find-calculator_calculator-type-name')) {
            $builder->whereRelation(
                relation: 'calculator_type',
                column: 'name',
                operator: 'like',
                value: "%{$this->request->get('find-calculator_calculator-type-name')}%",
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
            Input::make('find-calculator_calculator-type-name')
                ->title('Название')
                ->value($this->request->get('find-calculator_calculator-type-name'))
                ->placeholder('stickers..'),

            Select::make('find-calculator_calculator-type-id')
                ->fromModel(CalculatorType::class, 'name', 'id')
                ->title('Тип калькулятора')
                ->empty(),
        ];
    }
}
