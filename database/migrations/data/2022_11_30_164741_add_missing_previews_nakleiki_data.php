<?php

use App\Models\Calculator;
use App\Models\Preview;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $previews = [
            [
                'calculator_id' => 3829,
                'svg_id' => 'volume-complex-cutting-1',
                'form_id' => 57,
                'cutting_id' => 1,
                'width' => 215,
                'height' => 193
            ],
            [
                'calculator_id' => 3829,
                'svg_id' => 'volume-complex-cutting-2',
                'form_id' => 57,
                'cutting_id' => 2,
                'width' => 175,
                'height' => 153
            ],
            [
                'calculator_id' => 3829,
                'svg_id' => 'volume-complex-cutting-4',
                'form_id' => 57,
                'cutting_id' => 4,
                'width' => 158,
                'height' => 154
            ],
        ];

        foreach ($previews as $preview) {
            $calculator = Calculator::query()->find($preview['calculator_id']);

            Preview::query()->create([
                'calculator_id' => $calculator->id,
                'calculator_type_id' => $calculator->calculatorType->id,
                'svg_id' => $preview['svg_id'],
                'form_id' => $preview['form_id'],
                'cutting_id' => $preview['cutting_id'],
                'height' => $preview['height'],
                'width' => $preview['width']
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
