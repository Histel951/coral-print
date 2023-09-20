<?php

namespace App\Orchid\Screens\Calculators;

use App\Models\CalculatorType;
use App\Orchid\Layouts\Calculators\CalculatorTypeListLayout;
use App\Orchid\Layouts\Pivot\CalculatorTypeSelection;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class CalculatorTypeListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'calculator_types' => CalculatorType::filtersApplySelection(CalculatorTypeSelection::class)
                ->filters()
                ->defaultSort('id')
                ->paginate(),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Типы калькуляторов';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Link::make('Создать новый тип калькуляторов')->route('platform.calculator.type.create')];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [CalculatorTypeSelection::class, CalculatorTypeListLayout::class];
    }
}
