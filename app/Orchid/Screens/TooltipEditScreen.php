<?php

namespace App\Orchid\Screens;

use App\Events\CalculatorTooltipCacheClearEvent;
use App\Models\Tooltip;
use App\Orchid\Helpers\HAlert;
use App\Orchid\Layouts\FieldsListener;
use App\Services\TooltipService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Code;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class TooltipEditScreen extends EditScreen
{
    public Tooltip $tooltip;
    public TooltipService $tooltipService;

    public function __construct(Tooltip $tooltip, TooltipService $tooltipService)
    {
        $this->tooltip = $tooltip;
        $this->tooltipService = $tooltipService;
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')->method('edit'),
            Button::make('Удалить')
                ->type(Color::DANGER())
                ->method('delete')
                ->id('submitBtn'),
        ];
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Tooltip $tooltip): iterable
    {
        return [
            'tooltip' => $tooltip,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Редактирование';
    }

    public function asyncFields(Request $request): array
    {
        return [
            'tooltip.calculator_type_id' => $request->input('tooltip.calculator_type_id'),
            'tooltip.field_id' => $request->input('tooltip.field_id'),
        ];
    }

    /**
     * Views.
     *
     * @return iterable
     */
    public function layout(): iterable
    {
        return [
            FieldsListener::class,

            Layout::rows([
                Input::make('tooltip.name')->title('Название'),

                Select::make('tooltip.type')
                    ->id('tooltipTypes')
                    ->options($this->tooltipService->getTypes())
                    ->title('Тип'),

                CheckBox::make('tooltip.is_active')
                    ->title('Активен')
                    ->sendTrueOrFalse(),

                Code::make('tooltip.content')
                    ->title('Текст')
                    ->language('html')
                    ->lineNumbers(),
            ]),
        ];
    }

    public function edit(Request $request, Tooltip $tooltip)
    {
        if ($tooltip->fill($request->get('tooltip'))->save()) {
            Toast::success(HAlert::SUCCESS_MSG);

            event(new CalculatorTooltipCacheClearEvent());
            return redirect()->route('platform.tooltips');
        } else {
            Toast::error(HAlert::ERROR_MSG);
        }
    }

    public function delete(Tooltip $tooltip): RedirectResponse
    {
        $success = $tooltip->delete();
        HAlert::alert($success);

        return redirect()->route('platform.tooltips');
    }
}
