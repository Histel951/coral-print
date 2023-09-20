<?php

namespace App\Orchid\Filters\Pivot;

use App\Models\Cutting;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;

class PivotCuttingFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Связь нарезки';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['find-cutting_id', 'find-cutting_name'];
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
        if ($this->request->filled('find-cutting_id')) {
            $builder->where('cutting_id', $this->request->get('find-cutting_id'));
        }

        if ($this->request->filled('find-cutting_name')) {
            $builder->whereRelation(
                relation: 'cutting',
                column: 'name',
                operator: 'like',
                value: "%{$this->request->get('find-cutting_name')}%",
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
            Select::make('find-cutting_id')
                ->value($this->request->get('find-cutting_id'))
                ->title('ID нарезки')
                ->fromModel(Cutting::class, 'name', 'id')
                ->empty(),

            Input::make('find-cutting_name')
                ->value($this->request->get('find-cutting_name'))
                ->title('Название')
                ->placeholder('Нарезка с подсечкой..'),
        ];
    }
}
