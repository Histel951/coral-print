<?php

namespace App\Orchid\Filters;

use App\Models\CalculatorType;
use App\Services\TooltipService;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;

class TooltipFilter extends Filter
{
    public function __construct(private readonly TooltipService $tooltipService)
    {
        parent::__construct();
    }

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
                ->value($this->request->input('filter.id'))
                ->title('ID')
                ->type('number'),

            Input::make('filter[name]')
                ->value($this->request->input('filter.name'))
                ->title('Название')
                ->placeholder('Круглые с..'),

            Select::make('filter[type]')
                ->value($this->request->input('filter.type'))
                ->title('Тип')
                ->options($this->tooltipService->getTypes())
                ->empty(),

            Select::make('filter[calculator_type_id]')
                ->value($this->request->input('filter.calculator_type_id'))
                ->title('Тип калькулятора')
                ->fromModel(CalculatorType::class, 'name', 'id')
                ->empty(),

            Select::make('filter[field_id]')
                ->value($this->request->input('filter.field_id'))
                ->title('Поле')
                ->options(
                    $this->tooltipService->getFieldsToOptions(
                        CalculatorType::find(
                            $this->request->input('filter.calculator_type_id', CalculatorType::first()->id),
                        ),
                    ),
                )
                ->disabled(!$this->request->has('filter.calculator_type_id'))
                ->empty(),

            CheckBox::make('filter[is_active]')
                ->value((bool) $this->request->input('filter.is_active'))
                ->title('Активна')
                ->sendTrueOrFalse(),
        ];
    }
}
