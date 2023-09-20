<?php

use App\Models\Calculator;
use App\Models\CalculatorType;
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
        $boltsCalculator = Calculator::query()->where('name', 'Брошюры на болтах')->first();
        $notebooksCalculator = Calculator::query()->where('name', 'Блокноты')->first();

        $boltsCalculator->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'bolt_cover_select' => [
                    'text_decoration' => ''
                ]
            ]
        ]);

        $notebooksCalculator->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'page_count_sheets' => [
                    'label' => 'Листов'
                ]
            ]
        ]);

        $newColorsNames = [
            31 => 'Цветная с одной стороны',
            32 => 'Цветная с двух сторон',
            33 => 'Черно-белая с одной стороны',
            34 => 'Черно-белая с двух сторон',
            16 => 'Цветная с одной стороны',
            18 => 'Цветная, с двух сторон'
        ];

        foreach ($newColorsNames as $colorId => $newName) {
            Color::query()->find($colorId)->update([
                'name' => $newName
            ]);
        }

        $visitkiCalculators = CalculatorType::query()->where('name', 'businessCards')->first()->calculators;

        $visitkiCalculators->each(
            fn (Calculator $calculator) => $calculator->fields()->create([
                'type' => 'fields_options',
                'value' => [
                    'product_count_types' => [
                        'widthUl' => 230
                    ]
                ]
            ])
        );
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
