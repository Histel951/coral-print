<?php

namespace App\Orchid\Screens\Calculators;

use App\Models\CalculatorType;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class CalculatorTypeCreateScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Создание нового типа калькуляторов';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Button::make('Сохранить')->method('create')];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [Layout::columns([Layout::rows([Input::make('name')->title('Название типа калькулятора')])])];
    }

    public function create(CalculatorType $calculatorType, Request $request)
    {
        if ($calculatorType->fill($request->all())->save()) {
            Alert::success('Новый тип калькуляторов успешно создан!');
        } else {
            Alert::warning('Новый тип калькуляторов не создан.');
        }
    }
}
