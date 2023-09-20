<?php

namespace App\Orchid\Screens\Print;

use App\Events\SpecieTypeCacheClearEvent;
use App\Models\PrintSpecie;
use App\Models\SpecieType;
use App\Orchid\Layouts\SpecieTypeTypeNameListener;
use App\Orchid\Module\Print\BreadCrumbsCookie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class SpecieTypeCreateScreen extends Screen
{
    public PrintSpecie $printSpecie;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Request $request): iterable
    {
        return [
            'printSpecie' => PrintSpecie::find($request->get('printSpecie')),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Создание печати для: \"{$this->printSpecie->name}\"";
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::back(BreadCrumbsCookie::MaterialPrint, 'platform.module.print.materials'),
            Button::make('Сохранить')->method('create'),
        ];
    }

    public function asyncTranslirateTypeName(string $specieName): array
    {
        return [
            'specie_name' => $specieName,
            'specie_type_name' => transliterate($specieName),
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
            SpecieTypeTypeNameListener::class,
            Layout::columns([
                Layout::rows([
                    Input::make('specie.index_name')
                        ->title('Индекс')
                        ->placeholder('#Шир/1200')
                        ->required(),

                    Input::make('specie.height')
                        ->title('Высота')
                        ->placeholder('440')
                        ->type('number'),

                    Input::make('specie.width')
                        ->title('Ширина')
                        ->placeholder('1100')
                        ->type('number'),

                    Input::make('specie.duplex')
                        ->title('Индекс дуплекса')
                        ->placeholder('2')
                        ->value(2)
                        ->type('number'),

                    Input::make('printSpecie.name')
                        ->title('Разновидость печати')
                        ->readonly()
                        ->required(),

                    Input::make('printSpecie.id')
                        ->required()
                        ->hidden(),
                ]),
            ]),
        ];
    }

    public function create(Request $request, SpecieType $specieType): RedirectResponse
    {
        if (
            $specieType
                ->fill(
                    Arr::collapse([
                        $request->get('specie'),
                        [
                            'name' => $request->get('specie_name'),
                            'type_name' => $request->get('specie_type_name'),
                            'print_specie_id' => $request->get('printSpecie')['id'] ?? null,
                        ],
                    ]),
                )
                ->save()
        ) {
            Alert::success('Печать успешно создана!');
            event(new SpecieTypeCacheClearEvent());

            return redirect()->route('platform.print.specie.type.edit', [
                'specieType' => $specieType,
            ]);
        }

        Alert::success('Печать не создана.');
        return redirect()->route('platform.print.specie.type.create');
    }
}
