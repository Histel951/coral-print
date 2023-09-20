<?php

namespace App\Repositories\Color;

use App\Models\Calculator;
use App\Models\Color;
use App\Models\ColorCategory;
use App\Models\ColorPaint;
use Closure;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ColorPaintRepository implements ColorPaintRepositoryInterface
{
    /**
     * Возвращает цвета и краски для поля vue
     * @param Calculator $calculator
     * @param Closure|null $colorsBuilder
     * @return Collection
     */
    public function getColorPaintForField(Calculator $calculator, Closure $colorsBuilder = null): Collection
    {
        $colors = [
            'colors' => [],
            'paints' => ColorPaint::with(['image'])
                ->get(),
        ];

        $colorsEloquentBuilder = $calculator->colors();
        if (!is_null($colorsBuilder)) {
            $colorsBuilder->call($this, $colorsEloquentBuilder);
        }

        $colorsEloquentBuilder->with([
                'paints' => fn (BelongsToMany $paint) => $paint->with('image')
                    ->withPivot('is_additional_paint')
            ])
            ->get()
            ->map(function (Color $color) use (&$colors) {
                $paints = [];
                $color->paints->map(function (ColorPaint $paint) use (&$paints) {
                    $paintParam = Arr::collapse([
                        ['is_additional_paint' => $paint->pivot['is_additional_paint']],
                        $paint->toArray()
                    ]);
                    unset($paintParam['pivot']);

                    $paints[] = $paintParam;
                });

                $color->items = $paints;
                unset($color->paints);
                $colors['colors'][] = $color;
            });

        return collect($colors);
    }

    /**
     * Возвращает все краски от категории цветов
     * @param ColorCategory|string $colorCategory
     * @return Collection
     */
    public function getPaintsByColorCategory(ColorCategory|string $colorCategory): Collection
    {
        $paints = collect();
        if (!($colorCategory instanceof ColorCategory)) {
            $colorCategory = ColorCategory::where('type', $colorCategory)->first();
        }

        $colorCategory
            ->colors()
            ->with(['paints'])
            ->each(function (Color $color) use (&$paints) {
                $paints->push(...$color->paints);
            });

        return $paints->unique('id');
    }
}
