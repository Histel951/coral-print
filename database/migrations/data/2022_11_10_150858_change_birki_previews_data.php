<?php

use App\Models\Calculator;
use App\Models\Preview;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Arr;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $allCalculators = [3874, 3875, 3876];

        $previews = [
            [
                'is_rounding_corners' => 1,
                'svg_id' => 'visitki-rectangle-rounded-preview',
                'calculator_id' => 3874,
                'parameters_type' => 'sizing',
                'form_type' => 'visitki-rectangle-rounded-preview'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'visitki-rectangle-preview',
                'calculator_id' => 3874,
                'parameters_type' => 'sizing',
                'form_type' => 'visitki-rectangle-preview'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'visitki-rounded-preview',
                'calculator_id' => 3875,
                'parameters_type' => 'sizing',
                'form_type' => 'visitki-rounded-preview'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'visitki-complex-preview',
                'calculator_id' => 3876,
                'parameters_type' => 'sizing',
                'form_type' => 'visitki-complex-preview'
            ]
        ];

        foreach ($allCalculators as $calculatorId) {
            Preview::query()->where('calculator_id', $calculatorId)->delete();
        }

        foreach ($previews as $preview) {
            $calculator = Calculator::query()->find($preview['calculator_id']);

            Preview::query()->create(Arr::collapse([
                [
                    'calculator_id' => $calculator->id,
                    'calculator_type_id' => $calculator->calculatorType->id,
                ],
                $preview
            ]));
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
