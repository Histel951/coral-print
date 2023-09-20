<?php

namespace App\Orchid\Layouts\Flex;

use App\Models\ColorPaint;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\TD;

class FlexPaintsListLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'paints';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('name')->sort(),
            TD::make('consumption')->sort(),
            TD::make('price')->sort(),
            TD::make('price_percent')->sort(),
            TD::make('image')->render(function (ColorPaint $colorPaint): string {
                return "<img src='{$colorPaint->image?->url()}'>";
            }),
        ];
    }
}
