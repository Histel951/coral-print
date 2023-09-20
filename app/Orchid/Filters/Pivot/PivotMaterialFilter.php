<?php

namespace App\Orchid\Filters\Pivot;

use App\Models\Material;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;

class PivotMaterialFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Связь материалы';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['find-material_id', 'find-material_name'];
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
        if ($this->request->filled('find-material_id')) {
            $builder->where('material_id', '=', $this->request->get('find-material_id'));
        }

        if ($this->request->filled('find-material_name')) {
            $builder->whereRelation(
                relation: 'material',
                column: 'name',
                operator: 'like',
                value: "%{$this->request->get('find-material_name')}%",
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
            Select::make('find-material_id')
                ->value($this->request->get('find-material_id'))
                ->title('ID материала')
                ->fromModel(Material::class, 'name', 'id')
                ->empty(),

            Input::make('find-material_name')
                ->value($this->request->get('find-material_name'))
                ->title('Название материала')
                ->placeholder('Белая..'),
        ];
    }
}
