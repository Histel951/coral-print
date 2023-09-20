<?php

namespace App\Orchid\Screens\Design;

use App\Http\Requests\DesignPriceRequest;
use App\Models\DesignPrice;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class DesignPriceCreateScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Request $request): iterable
    {
        return [
            'design_id' => $request->design_id ?? null,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Создать новую цену на дизайн';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Button::make('Сохранить')->method('save')];
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
                    Input::make('designPrice.name')
                        ->title('Название')
                        ->placeholder('Услуга..'),

                    Input::make('designPrice.value')
                        ->title('Цена')
                        ->placeholder('90')
                        ->type('number'),

                    Input::make('designPrice.design_id')
                        ->value(request()->design_id ?? null)
                        ->hidden(),
                ]),
            ]),
        ];
    }

    public function save(DesignPriceRequest $request, DesignPrice $designPrice)
    {
        $request->validated();

        if ($designPrice->fill($request->get('designPrice'))->save()) {
            Alert::success('Цена на дизайн успешно создана!');

            return response()->redirectToRoute('platform.design.prices', [
                'filter[design_id]' => $request->get('designPrice')['design_id'],
            ]);
        } else {
            Alert::warning('Цена на дизайн не создана.');
        }
    }
}
