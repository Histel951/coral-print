<?php

use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\CalculatorType;
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
        $calculators = CalculatorType::query()->where('name', 'businessCards')->first()->calculators;

        $newConfig = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'product_count_types' => [
                    'multipleRound' => [
                        'multiple' => 50,
                        'message' => 'Тираж изменен, количество визиток должно быть кратно 50 шт'
                    ]
                ]
            ]
        ]);

        $calculators->each(
            fn (Calculator $calculator) => PivotCalculatorFieldsConfig::query()->create([
                'calculator_id' => $calculator->id,
                'calculator_fields_config_id' => $newConfig->getKey()
            ])
        );
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
