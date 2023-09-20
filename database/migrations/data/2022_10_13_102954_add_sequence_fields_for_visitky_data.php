<?php

use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Models\FormField;
use App\Models\FormFieldsSequence;
use App\Models\PivotCalculatorFieldsConfig;
use App\Models\PivotCalculatorPrintForm;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $businessCardType = CalculatorType::query()->where('name', 'businessCards')->first()
            ->calculators()->whereNotIn('id', [3831, 3834, 3835]);

        // fieldName => sequence
        $fieldSequence = [
            'width_height' => 1,
            'diameter' => 2,
            'product_count_types' => 3,
            'form' => 4,
            'print_type_select' => 5,
            'material' => 6,
            'foiling_face' => 7
        ];

        $businessCardType->each(function (Calculator $calculator) use ($fieldSequence): void {
            foreach ($fieldSequence as $fieldName => $sequence) {
                $formField = FormField::query()->where('name', $fieldName)->first();

                FormFieldsSequence::query()->create([
                    'calculator_id' => $calculator->id,
                    'form_field_id' => $formField->id,
                    'sequence' => $sequence
                ]);
            }
        });

        $businessCardType = CalculatorType::query()->where('name', 'businessCards')->first()
            ->calculators()->whereIn('id', [3831, 3834, 3835]);

        // fieldName => sequence
        $fieldSequence = [
            'width_height' => 1,
            'diameter' => 2,
            'product_count_types' => 3,
            'color' => 4,
            'material' => 5,
            'lam' => 6,
            'form' => 7,
            'foiling_face' => 8
        ];

        $businessCardType->each(function (Calculator $calculator) use ($fieldSequence): void {
            foreach ($fieldSequence as $fieldName => $sequence) {
                $formField = FormField::query()->where('name', $fieldName)->first();

                FormFieldsSequence::query()->create([
                    'calculator_id' => $calculator->id,
                    'form_field_id' => $formField->id,
                    'sequence' => $sequence
                ]);
            }
        });

        CalculatorType::query()->where('name', 'businessCards')->first()
            ->calculators()->each(
                fn (Calculator $calculator) => PivotCalculatorPrintForm::query()
                    ->where('print_form_id', 56)
                    ->where('calculator_id', $calculator->id)
                    ->delete()
            );

        PivotCalculatorFieldsConfig::query()
            ->where('calculator_id', 3834)
            ->where('calculator_fields_config_id', 73)
            ->delete();
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
