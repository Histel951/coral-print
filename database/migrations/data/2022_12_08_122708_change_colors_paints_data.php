<?php

use App\Models\Calculator;
use App\Models\Color;
use App\Models\ColorPaint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $allCalculators = Calculator::query()->whereIn('name', [
            'Фигурные этикетки в рулоне',
            'Прямоугольные этикетки в рулоне',
            'Овальные этикетки в рулоне',
            'Круглые этикетки в рулоне'
        ]);

        $allCalculators->each(function (Calculator $calculator) {
            $calculator->colors()->each(fn (Color $color) => $calculator->colors()->detach($color->id));
        });

        Color::query()->where('color_type_id', 1)->update([
            'color_type_id' => null
        ]);

        $colors = [
            [
                'name' => 'Чёрно-белая',
                'paints' => ['Black (K)']
            ],
            [
                'name' => 'Полноцвет',
                'paints' => ['Cian (C)', 'Magenta (M)', 'Yellow (Y)', 'Black (K)']
            ],
            [
                'name' => 'Белым цветом',
                'paints' => ['Белый (W)']
            ],
            [
                'name' => 'Полноцвет+белым',
                'paints' => ['Cian (C)', 'Magenta (M)', 'Yellow (Y)', 'Black (K)', 'Белый (W)']
            ]
        ];

        foreach ($colors as $color) {
            $newColor = Color::query()->create([
                'name' => $color['name']
            ]);

            $allCalculators->each(fn (Calculator $calculator) => $calculator->colors()->attach($newColor->getKey()));

            foreach ($color['paints'] as $paintName) {
                $newColor->paints()->attach(ColorPaint::query()->where('name', $paintName)->first()->id);
            }
        }
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
