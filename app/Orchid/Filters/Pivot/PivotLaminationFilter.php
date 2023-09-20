<?php

namespace App\Orchid\Filters\Pivot;

use App\Models\Lamination;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;

class PivotLaminationFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Связь ламинация';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['find-lamination_id', 'find-lamination_name'];
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
        if ($this->request->filled('find-lamination_id')) {
            $builder->where('lamination_id', $this->request->get('find-lamination_id'));
        }

        if ($this->request->filled('find-lamination_name')) {
            $builder->whereRelation(
                relation: 'lamination',
                column: 'name',
                operator: 'like',
                value: "%{$this->request->get('find-lamination_name')}%",
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
            Select::make('find-lamination_id')
                ->value($this->request->get('find-lamination_id'))
                ->fromModel(Lamination::class, 'name', 'id')
                ->title('ID ламинации')
                ->empty(),

            Input::make('find-lamination_name')
                ->value($this->request->get('find-lamination_name'))
                ->placeholder('Матовая..'),
        ];
    }
}
