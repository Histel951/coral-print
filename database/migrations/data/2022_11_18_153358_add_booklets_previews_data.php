<?php

use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Models\CalculatorTypePreviewOption;
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
        $allCalculators = [3867, 3868, 3869, 3870, 3871, 3872];

        $previews = [
            [
                'calculator_id' => 3867,
                'svg_id' => 'booklets-leaflets-preview',
                'parameters_type' => 'sizing',
                'form_type' => 'booklets-leaflets-preview'
            ],
            [
                'calculator_id' => 3868,
                'svg_id' => 'booklets-books-preview',
                'parameters_type' => 'sizing',
                'form_type' => 'booklets'
            ],
            [
                'calculator_id' => 3868,
                'svg_id' => 'booklets-books-down-preview',
                'parameters_type' => 'sizing',
                'form_type' => 'booklets_down'
            ],
            [
                'calculator_id' => 3869,
                'svg_id' => 'booklets-books-2-folds-preview',
                'parameters_type' => 'sizing',
                'form_type' => 'booklets'
            ],
            [
                'calculator_id' => 3869,
                'svg_id' => 'booklets-books-2-folds-down-preview',
                'parameters_type' => 'sizing',
                'form_type' => 'booklets_down'
            ],
            [
                'calculator_id' => 3870,
                'svg_id' => 'booklets-accordion-2-folds-preview',
                'parameters_type' => 'sizing',
                'form_type' => 'booklets'
            ],
            [
                'calculator_id' => 3870,
                'svg_id' => 'booklets-accordion-2-folds-down-preview',
                'parameters_type' => 'sizing',
                'form_type' => 'booklets_down'
            ],
            [
                'calculator_id' => 3871,
                'svg_id' => 'booklets-accordion-3-folds-preview',
                'parameters_type' => 'sizing',
                'form_type' => 'booklets_bigger'
            ],
            [
                'calculator_id' => 3871,
                'svg_id' => 'booklets-accordion-3-folds-down-preview',
                'parameters_type' => 'sizing',
                'form_type' => 'booklets_down_bigger'
            ],
            [
                'calculator_id' => 3872,
                'svg_id' => 'booklets-snails-3-folds-preview',
                'parameters_type' => 'sizing',
                'form_type' => 'booklets_bigger'
            ],
            [
                'calculator_id' => 3872,
                'svg_id' => 'booklets-snails-3-folds-down-preview',
                'parameters_type' => 'sizing',
                'form_type' => 'booklets_down_bigger'
            ]
        ];

        $calculator = Calculator::query()->find(3867);

        if ($calculator->calculatorType->previewOptions?->parameters_type !== 'sizing') {
            $previewOption = CalculatorTypePreviewOption::query()->create([
                'parameters_type' => 'sizing'
            ]);

            CalculatorType::query()->find($calculator->calculatorType->id)->update([
                'calculator_type_preview_option_id' => $previewOption->getKey()
            ]);
        }

        foreach ($allCalculators as $calculatorId) {
            Preview::query()->where('calculator_id', $calculatorId)->delete();
        }

        foreach ($previews as $preview) {
            $calculator = Calculator::query()->find($preview['calculator_id']);

            Preview::query()->create([
                'calculator_id' => $calculator->id,
                'calculator_type_id' => $calculator->calculatorType->id,
                'svg_id' => $preview['svg_id'],
                'form_type' => $preview['form_type']
            ]);
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
