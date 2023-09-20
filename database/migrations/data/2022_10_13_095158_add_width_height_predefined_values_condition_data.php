<?php

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
        $calculators = CalculatorType::query()
            ->where('name', 'businessCards')->first()->calculators->pluck('id');

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height' => [
                    'conditions' => [
                        'isUsePredefinedValues' => [
                            [
                                'field' => 'form',
                                'value' => [55]
                            ]
                        ],
                    ]
                ]
            ]
        ]);

        foreach ($calculators as $calculatorId) {
            PivotCalculatorFieldsConfig::query()->create([
                'calculator_id' => $calculatorId,
                'calculator_fields_config_id' => $config->getKey()
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
