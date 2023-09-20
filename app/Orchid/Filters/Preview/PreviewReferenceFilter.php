<?php

namespace App\Orchid\Filters\Preview;

use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Models\Cutting;
use App\Models\PrintForm;
use App\Models\PrintSize;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class PreviewReferenceFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'связи';
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
            Select::make('filter[calculator_id]')
                ->value((int) $this->request->input('filter.calculator_id'))
                ->title('Калькулятор')
                ->fromModel(Calculator::class, 'name', 'id')
                ->empty(),

            Select::make('filter[calculator_type_id]')
                ->value((int) $this->request->input('filter.calculator_type_id'))
                ->title('Тип калькулятора')
                ->fromModel(CalculatorType::class, 'name', 'id')
                ->empty(),

            Select::make('filter[cutting_id]')
                ->value((int) $this->request->input('filter.cutting_id'))
                ->title('Нарезка')
                ->fromModel(Cutting::class, 'name', 'id')
                ->empty(),

            Select::make('filter[form_id]')
                ->value((int) $this->request->input('filter.form_id'))
                ->title('Форма')
                ->fromModel(PrintForm::class, 'name', 'id')
                ->empty(),

            Select::make('filter[dependence]')
                ->title('Тип превью')
                ->options([
                    'common' => 'Обычное',
                    'reversal' => 'В развороте',
                ])
                ->value((int) $this->request->input('filter.dependence'))
                ->empty(),

            Select::make('filter[print_size_id]')
                ->title('Размер')
                ->value((int) $this->request->input('filter.print_size_id'))
                ->fromModel(PrintSize::class, 'name', 'id')
                ->empty(),
        ];
    }
}
