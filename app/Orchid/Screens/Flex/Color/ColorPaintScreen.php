<?php

namespace App\Orchid\Screens\Flex\Color;

use App\Models\ColorCategory;
use App\Orchid\Layouts\Flex\Color\ColorPaintLayout;
use App\Repositories\Color\ColorPaintRepositoryInterface;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class ColorPaintScreen extends Screen
{
    /**
     * @var ColorCategory
     */
    public ColorCategory $colorCategory;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(ColorCategory $colorCategory, ColorPaintRepositoryInterface $colorPaintRepository): iterable
    {
        return [
            'colorCategory' => $colorCategory,
            'paints' => $colorPaintRepository->getPaintsByColorCategory($colorCategory),
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Создать')->route('platform.flex.color.paint.create', [
                'colorCategory' => $this->colorCategory,
            ]),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Краски категории цвета \"{$this?->colorCategory?->name}\" [{$this?->colorCategory?->id}]";
    }

    public function layout(): iterable
    {
        return [ColorPaintLayout::class];
    }
}
