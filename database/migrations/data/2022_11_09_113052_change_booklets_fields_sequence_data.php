<?php

use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\CalculatorType;
use App\Models\FormField;
use App\Models\FormFieldsSequence;
use App\Models\PivotCalculatorFieldsConfig;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculators = CalculatorType::query()->where('name', 'booklets')->first()->calculators;

        $fieldSequence = [
            'product_count' => 2,
            'print_select' => 3,
            'material' => 4,
            'lam' => 5
        ];

        $calculators->each(function (Calculator $calculator) use ($fieldSequence) {
            foreach ($fieldSequence as $fieldName => $sequence) {
                $field = FormField::query()->where('name', $fieldName)->first();

                FormFieldsSequence::query()->create([
                    'calculator_id' => $calculator->id,
                    'form_field_id' => $field->id,
                    'sequence' => $sequence
                ]);
            }
        });

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'material' => [
                    'label' => 'Бумага',
                    'deps' => ['width', 'height', 'print_select']
                ],
            ]
        ]);

        $calculators->each(fn (Calculator $calculator) => PivotCalculatorFieldsConfig::query()->create([
            'calculator_fields_config_id' => $config->getKey(),
            'calculator_id' => $calculator->id
        ]));

        $calculators = CalculatorType::query()->where('name', 'labels')->first()->calculators;

        $calculators->each(fn (Calculator $calculator) => PivotCalculatorFieldsConfig::query()->where('calculator_id', $calculator->id)->latest()->delete());
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
