<?php

use App\Models\Calculator;
use App\Models\Color;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $newCalculatorColors = [
            [
                'colors' => ['Белым цветом', 'Полноцвет+белым'],
                'calculator' => Calculator::query()->where('name', 'На прозрачной плёнке с белым')->first()
            ],
            [
                'colors' => ['Чёрно-белая', 'Полноцвет', 'Белым цветом', 'Полноцвет+белым'],
                'calculator' => Calculator::query()->where('name', 'Этикетки с персонализацией')->first()
            ],
            [
                'colors' => ['Чёрно-белая', 'Полноцвет', 'Белым цветом', 'Полноцвет+белым'],
                'calculator' => Calculator::query()->where('name', 'Термоэтикетка')->first()
            ]
        ];

        foreach ($newCalculatorColors as $item) {
            foreach ($item['colors'] as $color) {
                $color = Color::query()->where('name', $color)->first();
                $item['calculator']->colors()->attach($color->id);
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
    }
};
