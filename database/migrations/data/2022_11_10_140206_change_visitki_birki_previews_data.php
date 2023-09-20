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
        $calculatorsCommon = [3831, 3833, 3836];
        $calculatorsRounded = [3834];
        $calculatorsComplex = [3835];
        $calculatorsFoilings = [3832];

        $allCalcs = Arr::collapse([$calculatorsCommon, $calculatorsRounded, $calculatorsComplex, $calculatorsFoilings]);

        $previews = [
            [
                'is_rounding_corners' => 1,
                'svg_id' => 'visitki-rectangle-rounded-preview',
                'calculator_ids' => $calculatorsCommon,
                'parameters_type' => 'sizing',
                'form_type' => 'visitki-rectangle-rounded-preview'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'visitki-rectangle-preview',
                'calculator_ids' => $calculatorsCommon,
                'parameters_type' => 'sizing',
                'form_type' => 'visitki-rectangle-preview'
            ],
            [
                'is_rounding_corners' => 1,
                'svg_id' => 'visitki-rectangle-rounded-preview',
                'calculator_ids' => $calculatorsFoilings,
                'form_id' => 55,
                'parameters_type' => 'sizing',
                'form_type' => 'visitki-rectangle-rounded-preview'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'visitki-rectangle-preview',
                'calculator_ids' => $calculatorsFoilings,
                'form_id' => 55,
                'parameters_type' => 'sizing',
                'form_type' => 'visitki-rectangle-preview'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'visitki-rounded-preview',
                'calculator_ids' => $calculatorsFoilings,
                'form_id' => 54,
                'parameters_type' => 'sizing',
                'form_type' => 'visitki-rounded-preview'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'visitki-complex-preview',
                'calculator_ids' => $calculatorsFoilings,
                'form_id' => 57,
                'parameters_type' => 'sizing',
                'form_type' => 'visitki-complex-preview'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'visitki-rounded-preview',
                'calculator_ids' => $calculatorsRounded,
                'parameters_type' => 'sizing',
                'form_type' => 'visitki-rounded-preview'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'visitki-complex-preview',
                'calculator_ids' => $calculatorsComplex,
                'parameters_type' => 'sizing',
                'form_type' => 'visitki-complex-preview'
            ],
        ];

        foreach ($allCalcs as $calculatorId) {
            Preview::query()->where('calculator_id', $calculatorId)->delete();
        }

        foreach ($previews as $preview) {
            foreach ($preview['calculator_ids'] as $calculatorId) {
                $calculator = Calculator::query()->find($calculatorId);

                Preview::query()->create(Arr::collapse([
                    [
                        'calculator_id' => $calculator->id,
                        'calculator_type_id' => $calculator->calculatorType->id,
                    ],
                    $preview
                ]));
            }
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
