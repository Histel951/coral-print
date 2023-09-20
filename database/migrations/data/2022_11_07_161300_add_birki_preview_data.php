<?php

use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Models\CalculatorTypePreviewOption;
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
        $previews = [
            [
                'is_rounding_corners' => 1,
                'svg_id' => 'visitki-common-rounded',
                'calculator_id' => 3874,
                'parameters_type' => 'sizing',
                'form_type' => 'rectangle'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'visitki-common',
                'calculator_id' => 3874,
                'parameters_type' => 'sizing',
                'form_type' => 'rectangle'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'visitki-rounded',
                'calculator_id' => 3875,
                'parameters_type' => 'sizing',
                'form_type' => 'rounded'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'visitki-complex',
                'calculator_id' => 3876,
                'parameters_type' => 'sizing',
                'form_type' => 'complex'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'volbers-common',
                'calculator_id' => 3877,
                'parameters_type' => 'sizing',
                'form_type' => 'birki-rectangle'
            ],
            [
                'is_rounding_corners' => 1,
                'svg_id' => 'volbers-common-rounded',
                'calculator_id' => 3877,
                'parameters_type' => 'sizing',
                'form_type' => 'birki-rectangle'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'volbers-rounded',
                'calculator_id' => 3878,
                'parameters_type' => 'sizing',
                'form_type' => 'birki-rounded'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'volbers-complex',
                'calculator_id' => 3879,
                'parameters_type' => 'sizing',
                'form_type' => 'birki-complex'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'henger',
                'calculator_id' => 3880,
                'parameters_type' => 'sizing',
                'form_type' => 'birki-henger'
            ]
        ];

        $calculator = Calculator::query()->find(3874);

        if ($calculator->calculatorType->previewOptions?->parameters_type !== 'sizing') {
            $previewOption = CalculatorTypePreviewOption::query()->create([
                'parameters_type' => 'sizing'
            ]);

            CalculatorType::query()->find($calculator->calculatorType->id)->update([
                'calculator_type_preview_option_id' => $previewOption->getKey()
            ]);
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
    public function down(): void
    {
        //
    }
};
