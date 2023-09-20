<?php

namespace App\Orchid\Screens\PrintModule;

use App\Models\Material;
use App\Orchid\Layouts\Material\MaterialSelection;
use App\Orchid\Layouts\Print\SpecieTypeListLayout;
use App\Orchid\Layouts\PrintModule\MaterialPrintLayout;
use App\Orchid\Module\Print\BreadCrumbsCookie;
use App\Orchid\Module\Print\PrintBreadCrumbs;
use Illuminate\Pagination\LengthAwarePaginator;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use App\Models\SpecieType;
use Orchid\Support\Facades\Layout;

class PrintsMaterialScreen extends Screen
{
    public LengthAwarePaginator $materials;

    public LengthAwarePaginator $specieType;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'materials' => Material::with(['category', 'printSpecie'])
                ->filtersApplySelection(MaterialSelection::class)
                ->filters()
                ->defaultSort('sequence')
                ->paginate(),

            'specieType' => SpecieType::filters()
                ->defaultSort('id')
                ->paginate(),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Материалы печати: \"{$this->materials->first()?->printSpecie?->name}\"";
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Создать материал')->route('platform.module.print.type.material.create', [
                'specieType' => $this->materials->first()?->printSpecie,
            ]),
            Link::make('Создать печать')->route('platform.module.print.specie.type.create', [
                'printSpecie' => $this->specieType->first()?->printSpecie,
            ]),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        (new PrintBreadCrumbs())->set(BreadCrumbsCookie::MaterialPrint);

        return [
            Layout::columns([
                Layout::tabs([
                    'Материалы' => [MaterialSelection::class, MaterialPrintLayout::class],
                    'Печать' => [SpecieTypeListLayout::class],
                ]),
            ]),
        ];
    }
}
