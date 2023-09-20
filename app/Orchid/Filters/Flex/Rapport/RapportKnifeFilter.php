<?php

namespace App\Orchid\Filters\Flex\Rapport;

use App\Models\PrintForm;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;

class RapportKnifeFilter extends Filter
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
        if (isset($this->request->input('filter')['print_form.name'])) {
            $builder->where('print_form_id', $this->request->input('filter')['print_form.name']);
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
            Select::make('filter[print_form.name]')
                ->fromModel(PrintForm::class, 'name', 'id')
                ->value($this->request->input('filter')['print_form.name'] ?? null)
                ->title('Форма')
                ->empty(),

            Input::make('filter[height]')
                ->type('number')
                ->value($this->request->input('filter.height'))
                ->min(0)
                ->title('Ширина'),

            Input::make('filter[width]')
                ->type('number')
                ->value($this->request->input('filter.width'))
                ->min(0)
                ->title('Длина')
        ];
    }
}
