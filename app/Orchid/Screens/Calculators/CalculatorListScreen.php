<?php

namespace App\Orchid\Screens\Calculators;

use App\Models\Calculator;
use App\Orchid\Layouts\Calculators\CalculatorListLayout;
use App\Orchid\Layouts\Pivot\CalculatorSelection;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class CalculatorListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'calculators' => Calculator::filters()
                ->filtersApplySelection(CalculatorSelection::class)
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
        return 'Калькуляторы';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Link::make('Создать калькулятор')->route('platform.calculator.create')];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [CalculatorSelection::class, CalculatorListLayout::class];
    }
}
