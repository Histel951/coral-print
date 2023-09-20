<?php

use App\Models\Color;
use App\Models\ColorCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $colorCategoryFlexa = ColorCategory::query()->create([
            'type' => 'flex',
            'name' => 'Флекса'
        ]);

        $this->setColorsToCategory($colorCategoryFlexa, Color::query()->whereIn('name', [
            'Цветной (C,M,Y,K)',
            'Только белый (W)',
            'Цветной с белым (C,M,Y,K+W)',
            'Black (K)',
            'Выбрать вручную'
        ]));
    }

    /**
     * @param ColorCategory $category
     * @param Color[]|Builder $colors
     * @return void
     */
    public function setColorsToCategory(ColorCategory $category, Builder $colors): void
    {
        $colors->each(fn (Color $color) => $category->colors()->attach($color->id));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        //
    }
};
