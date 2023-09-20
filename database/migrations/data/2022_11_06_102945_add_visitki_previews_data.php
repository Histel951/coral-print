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
        $calculatorsCommon = [3831, 3833, 3836];
        $calculatorsRounded = [3834];
        $calculatorsComplex = [3835];
        $calculatorsFoilings = [3832];

        $previews = [
            [
                'is_rounding_corners' => 1,
                'svg_id' => 'visitki-common-rounded',
                'calculator_ids' => $calculatorsCommon,
                'parameters_type' => 'sizing',
                'form_type' => 'rectangle'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'visitki-common',
                'calculator_ids' => $calculatorsCommon,
                'parameters_type' => 'sizing',
                'form_type' => 'rectangle'
            ],
            [
                'is_rounding_corners' => 1,
                'svg_id' => 'visitki-common-rounded',
                'calculator_ids' => $calculatorsFoilings,
                'form_id' => 55,
                'parameters_type' => 'sizing',
                'form_type' => 'rectangle'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'visitki-common',
                'calculator_ids' => $calculatorsFoilings,
                'form_id' => 55,
                'parameters_type' => 'sizing',
                'form_type' => 'rectangle'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'visitki-rounded',
                'calculator_ids' => $calculatorsFoilings,
                'form_id' => 54,
                'parameters_type' => 'sizing',
                'form_type' => 'rounded'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'visitki-complex',
                'calculator_ids' => $calculatorsFoilings,
                'form_id' => 57,
                'parameters_type' => 'sizing',
                'form_type' => 'complex'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'visitki-rounded',
                'calculator_ids' => $calculatorsRounded,
                'parameters_type' => 'sizing',
                'form_type' => 'rounded'
            ],
            [
                'is_rounding_corners' => 0,
                'svg_id' => 'visitki-complex',
                'calculator_ids' => $calculatorsComplex,
                'parameters_type' => 'sizing',
                'form_type' => 'complex'
            ],
        ];

        $calculator = Calculator::query()->find($calculatorsCommon[0]);

        if ($calculator->calculatorType->previewOptions?->parameters_type !== 'sizing') {
            $previewOption = CalculatorTypePreviewOption::query()->create([
                'parameters_type' => 'sizing'
            ]);

            CalculatorType::query()->find($calculator->calculatorType->id)->update([
                'calculator_type_preview_option_id' => $previewOption->getKey()
            ]);
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
    public function down(): void
    {
        //
    }
};
