<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout as LayoutType;
use Orchid\Screen\Layouts\Listener;
use Orchid\Support\Facades\Layout;

class MaterialPriceListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = ['price_percent', 'cost_price', 'price', 'material_id'];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = 'asyncPrice';

    /**
     * @return LayoutType[]
     */
    protected function layouts(): iterable
    {
        return [
            Layout::rows([
                Input::make('material_id')->hidden(),

                Input::make('cost_price')
                    ->title('Себестоимость')
                    ->step('0.01')
                    ->placeholder('1200')
                    ->type('number'),

                Input::make('price_percent')
                    ->title('Наценка в процентах')
                    ->placeholder('100')
                    ->type('number'),

                Input::make('price')
                    ->title('Цена')
                    ->step('0.01')
                    ->placeholder('139.1')
                    ->type('number')
                    ->readonly()
                    ->canSee($this->query->has('price'))
                    ->required(),
            ]),
        ];
    }
}
