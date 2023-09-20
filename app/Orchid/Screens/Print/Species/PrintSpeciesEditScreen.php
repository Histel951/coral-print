<?php

namespace App\Orchid\Screens\Print\Species;

use App\Models\PrintSpecie;
use App\Orchid\Screens\EditScreen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PrintSpeciesEditScreen extends EditScreen
{
    public PrintSpecie $printSpecie;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(PrintSpecie $printSpecie): iterable
    {
        return [
            'printSpecie' => $printSpecie,
            'printSpeciePrices' => $printSpecie
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Редактирование разновидности печати \"{$this->printSpecie->name}\" [{$this->printSpecie->id}]";
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
                Layout::tabs([
                    'Печать' => [
                        Layout::rows([
                            Input::make('printSpecie.name')
                                ->title('Название')
                                ->placeholder('Название..'),

                            Input::make('printSpecie.volume')
                                ->title('Объём')
                                ->step('0.001')
                                ->type('number')
                                ->placeholder('100.001'),

                            Input::make('printSpecie.sequence')
                                ->title('Порядок')
                                ->type('number')
                                ->placeholder('50'),
                        ]),
                    ],
                    'Цены печати' => [

                    ]
                ])
            ])
        ];
    }

    public function edit(Request $request, PrintSpecie $printSpecie): void
    {
        if ($printSpecie->fill($request->get('printSpecie'))->save()) {
            Alert::success('Категория успешно обновлена!');
        } else {
            Alert::warning('Категория не обновлена');
        }
    }

    public function delete(PrintSpecie $printSpecie): RedirectResponse
    {
        $printSpecie->delete();

        return redirect()->route('platform.print.species');
    }
}
