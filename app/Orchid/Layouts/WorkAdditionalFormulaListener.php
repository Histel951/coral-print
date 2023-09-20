<?php

namespace App\Orchid\Layouts;

use App\Models\Formula;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Listener;
use Orchid\Support\Facades\Layout;

class WorkAdditionalFormulaListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = ['formula_id', 'weight', 'volume', 'workAdditional'];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = 'asyncHiddenWidthHeight';

    /**
     * @return Layout[]
     */
    protected function layouts(): iterable
    {
        return [
            Layout::columns([
                Layout::rows([
                    Relation::make('formula_id')
                        ->title('Формула')
                        ->required()
                        ->fromModel(Formula::class, 'value', 'id'),

                    Input::make('weight')
                        ->title('Вес')
                        ->type('number')
                        ->placeholder('80')
                        ->canSee($this->query->get('hiddenWidthHeight')),

                    Input::make('volume')
                        ->title('Объём')
                        ->type('number')
                        ->placeholder('235')
                        ->canSee($this->query->get('hiddenWidthHeight')),
                ]),
            ]),
        ];
    }
}
