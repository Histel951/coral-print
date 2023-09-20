<?php

namespace App\Orchid\Filters\Pivot;

use App\Models\CalculatorSub;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;

class PivotCalculatorSubFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Связь под калькулятор';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['find-calculator-sub_id', 'find-calculator-sub_name'];
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
        if ($this->request->filled('find-calculator-sub_id')) {
            $builder->where('calculator_sub_id', $this->request->get('find-calculator-sub_id'));
        }

        if ($this->request->filled('find-calculator-sub_name')) {
            $builder->whereRelation(
                relation: 'calculator_sub',
                column: 'name',
                operator: 'like',
                value: "%{$this->request->get('find-calculator-sub_name')}%",
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
            Select::make('find-calculator-sub_id')
                ->value($this->request->get('find-calculator-sub_id'))
                ->title('ID под калькулятора')
                ->fromModel(CalculatorSub::class, 'name', 'id')
                ->empty(),

            Input::make('find-calculator-sub_name')
                ->value($this->request->get('find-calculator-sub_name'))
                ->placeholder('cover..')
                ->title('Название'),
        ];
    }
}
