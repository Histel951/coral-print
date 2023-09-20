<?php

use App\Models\CalculatorFieldsConfig;
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
        $configValue = [
            'material' => [
                'conditions' => [
                    'readonly' => [
                        [
                            'field' => 'reverse_sticker',
                            'value' => 1
                        ]
                    ],
                    'selected' => [
                        [
                            'field' => 'reverse_sticker',
                            'value' => 1,
                            'selected_value' => 22
                        ]
                    ]
                ]
            ]
        ];

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => $configValue
        ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => 3819,
            'calculator_fields_config_id' => $config->getKey()
        ]);
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
