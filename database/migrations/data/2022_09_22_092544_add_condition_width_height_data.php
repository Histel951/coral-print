<?php

use App\Models\Calculator;
use App\Models\PivotCalculatorFieldsConfig;
use Illuminate\Database\Migrations\Migration;
use App\Models\CalculatorFieldsConfig;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $newConfig = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height' => [
                    'conditions' => [
                        'max_size_disable' => [
                            [
                                'value' => 150,
                                'field' => 'cutting',
                                'values' => [3, 4]
                            ]
                        ]
                    ]
                ],
                'diameter' => [
                    'conditions' => [
                        'max_size_disable' => [
                            [
                                'value' => 150,
                                'field' => 'cutting',
                                'values' => [3, 4]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $allCalculatorStickers = Calculator::query()->where('calculator_type_id', 3814);

        $allCalculatorStickers->each(fn (Calculator $calculator) => PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_fields_config_id' => $newConfig->getKey()
        ]));
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
