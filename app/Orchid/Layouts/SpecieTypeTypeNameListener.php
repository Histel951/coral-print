<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Listener;

class SpecieTypeTypeNameListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = ['specie_name', 'specie_type_name'];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = 'asyncTranslirateTypeName';

    /**
     * @return Layout[]
     */
    protected function layouts(): iterable
    {
        return [
            \Orchid\Support\Facades\Layout::rows([
                Input::make('specie_name')
                    ->placeholder('Печать')
                    ->title('Название')
                    ->required(),

                Input::make('specie_type_name')
                    ->placeholder('Pechaty 1/4')
                    ->title('Тип')
                    ->readonly()
                    ->canSee($this->query->has('specie_type_name'))
                    ->required(),
            ]),
        ];
    }
}
