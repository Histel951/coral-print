<?php

namespace App\Orchid\Screens\Print;

use App\Models\SpecieType;
use App\Orchid\Layouts\Print\SpecieTypeListLayout;
use Orchid\Screen\Screen;

class SpecieTypeListScreen extends Screen
{
    public SpecieType $specieType;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(SpecieType $specieType): iterable
    {
        return [
            'specieType' => $specieType,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->specieType->name;
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
        return [SpecieTypeListLayout::class];
    }
}
