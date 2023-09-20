<?php

namespace App\Repositories\Color;

use App\Models\Calculator;
use App\Models\ColorCategory;
use Closure;
use Illuminate\Support\Collection;

interface ColorPaintRepositoryInterface
{
    /**
     * Возвращает цвета и краски для поля vue
     * @param Calculator $calculator
     * @param Closure|null $colorsBuilder
     * @return Collection
     */
    public function getColorPaintForField(Calculator $calculator, Closure $colorsBuilder = null): Collection;

    /**
     * Возвращает все краски от категории цветов
     * @param ColorCategory|string $colorCategory
     * @return Collection
     */
    public function getPaintsByColorCategory(ColorCategory|string $colorCategory): Collection;
}
