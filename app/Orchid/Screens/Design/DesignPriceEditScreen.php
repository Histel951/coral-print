<?php

namespace App\Orchid\Screens\Design;

use App\Http\Requests\DesignPriceRequest;
use App\Models\Design;
use App\Models\DesignPrice;
use App\Orchid\Screens\EditScreen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class DesignPriceEditScreen extends EditScreen
{
    public DesignPrice $designPrice;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(DesignPrice $designPrice): iterable
    {
        return [
            'designPrice' => $designPrice,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Редактирование цены дизайна \"{$this->designPrice->name}\" [{$this->designPrice->id}]";
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
                        ->placeholder('Название..'),

                    Input::make('designPrice.value')
                        ->title('Цена')
                        ->type('number')
                        ->placeholder(200),

                    Select::make('designPrice.design_id')->fromModel(Design::class, 'name', 'id'),

                    Input::make('designPrice.sort')
                        ->title('Порядок')
                        ->type('number')
                        ->placeholder(1),
                ]),
            ]),
        ];
    }

    public function edit(DesignPrice $designPrice, DesignPriceRequest $request)
    {
        $request->validated();

        if ($designPrice->fill($request->get('designPrice'))->save()) {
            Alert::success('Цена дизайна успешно обновлена!');

            return redirect()->route('platform.design.prices', ['filter[design_id]' => $designPrice->design->id]);
        } else {
            Alert::success('Цена дизайна не обновлена.');
        }
    }

    public function delete(DesignPrice $designPrice)
    {
        $designPrice->delete();

        return redirect()->route('platform.design.prices', ['filter[design_id]' => $designPrice->design->id]);
    }
}
