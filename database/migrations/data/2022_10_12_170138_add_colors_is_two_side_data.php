<?php

use App\Models\Color;
use App\Models\PivotCalculatorColor;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Color::query()->find(18)->update([
            'is_two_side' => 1
        ]);

        PivotCalculatorColor::query()->where('calculator_id', 3832)->delete();

        $prints = [
            [
                'print_id' => 129,
                'name' => 'Цветная, с одной стороны',
                'is_two_side' => 0
            ],
            [
                'print_id' => 130,
                'name' => 'Цветная, с двух сторон',
                'is_two_side' => 1,
            ],
        ];

        foreach ($prints as $print) {
            $newColor = Color::query()->create($print);

            PivotCalculatorColor::query()->create([
                'calculator_id' => 3832,
                'color_id' => $newColor->getKey()
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
