<?php

namespace App\Orchid\Screens\Design;

use App\Models\CalculatorType;
use App\Models\Design;
use App\Orchid\Screens\EditScreen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class DesignEditScreen extends EditScreen
{
    public Design $design;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Design $design): iterable
    {
        return [
            'design' => $design,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Редактирование дизайна \"{$this->design->name}\" [{$this->design->id}]";
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::columns([
                Layout::rows([
                    Input::make('design.name')
                        ->title('Название')
                        ->placeholder('Название..'),

                    Select::make('design.calculator_type_id')
                        ->title('Тип калькулятора')
                        ->fromModel(CalculatorType::class, 'name', 'id'),
                ]),
            ]),
        ];
    }

    public function edit(Request $request, Design $design)
    {
        if ($design->fill($request->get('design'))->save()) {
            Alert::success('Дизайн успешно обновлён');
        } else {
            Alert::warning('Дизайн не обновлён.');
        }
    }

    public function delete(Design $design)
    {
        $design->prices()->delete();
        $design->delete();

        return redirect()->route('platform.designs');
    }
}
