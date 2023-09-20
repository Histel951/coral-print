<?php

namespace App\Orchid\Screens\Design;

use App\Models\Design;
use App\Models\DesignPrice;
use App\Orchid\Layouts\Design\DesignPriceListLayout;
use App\Orchid\Layouts\Design\DesignPriceSelection;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class DesignPriceListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'designPrices' => DesignPrice::filters()
                ->defaultSort('sort')
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
        $designName = \request()->filter ? Design::find(\request()->filter['design_id'])?->name ?? '' : '';

        return "Цены дизайна $designName";
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Создать')->route('platform.design.price.create', [
                'design_id' => \request()->filter['design_id'] ?? null,
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
        return [DesignPriceSelection::class, DesignPriceListLayout::class];
    }
}
