<?php

namespace App\Orchid\Screens\PrintModule;

use App\Models\MaterialSubType;
use App\Orchid\Layouts\PrintModule\PrintMaterialColorLayout;
use Orchid\Screen\Screen;
use Illuminate\Pagination\LengthAwarePaginator;

class PrintMaterialColorScreen extends Screen
{
    public LengthAwarePaginator $materialColors;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'materialColors' => MaterialSubType::with(['material'])
                ->filters()
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
        return "Цвета материала: \"{$this->materialColors->first()->material->name}\"";
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [PrintMaterialColorLayout::class];
    }
}
