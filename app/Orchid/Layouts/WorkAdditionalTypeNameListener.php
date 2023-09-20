<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Listener;

class WorkAdditionalTypeNameListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = ['work_additional_name', 'work_additional_type_name'];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = 'asyncWorkAdditionalTypeName';

    /**
     * @return Layout[]
     */
    protected function layouts(): iterable
    {
        return [
            \Orchid\Support\Facades\Layout::rows([
                Input::make('work_additional_name')
                    ->title('Название')
                    ->placeholder('Люверсы..')
                    ->required(),

                Input::make('work_additional_type_name')
                    ->title('Название типа')
                    ->placeholder('Lyversi')
                    ->readonly()
                    ->canSee($this->query->has('work_additional_type_name'))
                    ->required(),
            ]),
        ];
    }
}
