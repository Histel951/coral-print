<?php

namespace App\Orchid\Filters\Pivot;

use App\Models\PrintModel;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;

class PivotPrintFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Связь печати';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['find-print_name', 'find-print_id'];
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
        if ($this->request->filled('find-print_id')) {
            $builder->where('print_id', '=', $this->request->get('find-print_id'));
        }

        if ($this->request->filled('find-print_name')) {
            $builder->whereRelation(
                relation: 'print_',
                column: 'name',
                operator: 'like',
                value: "%{$this->request->get('find-print_name')}%",
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
            Select::make('find-print_id')
                ->value($this->request->get('find-print_id'))
                ->title('ID печати')
                ->fromModel(PrintModel::class, 'name', 'id')
                ->empty(),

            Input::make('find-print_name')
                ->value($this->request->get('find-print_name'))
                ->title('Название печати')
                ->placeholder('Струйная..'),
        ];
    }
}
