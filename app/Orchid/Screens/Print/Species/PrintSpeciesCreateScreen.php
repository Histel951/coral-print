<?php

namespace App\Orchid\Screens\Print\Species;

use App\Models\PrintSpecie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PrintSpeciesCreateScreen extends Screen
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
        return 'Создание разновидности печати';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')->method('save')
        ];
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
                    Input::make('printSpecies.name')
                        ->title('Название')
                        ->placeholder('Баннер..'),

                    Input::make('printSpecies.volume')
                        ->title('Объём')
                        ->type('number')
                        ->step('0.001')
                        ->placeholder('100.001'),

                    Input::make('printSpecies.sequence')
                        ->title('Порядок')
                        ->type('number')
                        ->placeholder('50'),
                ])
            ])
        ];
    }

    public function save(PrintSpecie $printSpecie, Request $request): RedirectResponse
    {
        if ($printSpecie->fill($request->get('printSpecies'))->save()) {
            Alert::success("Разновидность печати успешно создана.");

            return redirect()->route('platform.print.specie.edit', ['printSpecie' => $printSpecie]);
        }

        Alert::warning("Разновидность печати не создана.");
        return redirect()->route('platform.print.specie.create');
    }
}
