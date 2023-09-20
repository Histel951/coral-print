<?php

namespace App\Orchid\Layouts;

use App\Models\CalculatorType;
use App\Services\TooltipService;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Listener;
use Orchid\Support\Facades\Layout;

class FieldsListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = ['tooltip.calculator_type_id', 'tooltip.field_id'];

    public function __construct(private readonly TooltipService $tooltipService)
    {
    }

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = 'asyncFields';

    /**
     * @return Layout[]
     */
    protected function layouts(): iterable
    {
        return [
            Layout::rows([
                Select::make('tooltip.calculator_type_id')
                    ->id('types')
                    ->fromModel(CalculatorType::class, 'name')
                    ->empty()
                    ->title('Типы калькуляторов'),

                Select::make('tooltip.field_id')
                    ->title('Поле')
                    ->options(
                        $this->tooltipService->getFieldsToOptions(
                            CalculatorType::find(
                                $this->query->get('tooltip.calculator_type_id', CalculatorType::first()->id),
                            ),
                        ),
                    )
                    ->id('sel')
                    ->empty(),
            ]),
        ];
    }
}
