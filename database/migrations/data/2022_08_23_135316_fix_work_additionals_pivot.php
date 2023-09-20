<?php

use App\Models\CalculatorFieldsConfig;
use App\Models\PivotCalculatorFieldsConfig;
use App\Models\PivotWorkAdditional;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        PivotWorkAdditional::query()
            ->where('work_additional_id', 44)
            ->where('calculator_id', 3821)
            ->delete();

        PivotWorkAdditional::query()->find(13)->delete();
        PivotWorkAdditional::query()->find(5)->delete();

        // {"white_print": {"conditions": {"visible": [{"field": "print_type", "value": 14}]}}, "complex_form":
        // {"conditions": {"checked": [{"field": "mounting_film", "value": 1}], "readonly": [{"field": "mounting_film", "value": 1}]}}}

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'checkboxes_options',
            'value' => [
                'reverse_sticker' => [
                    'conditions' => [
                        'readonly' => [
                            [
                                'field' => 'volume',
                                'value' => 1
                            ]
                        ],
                        'unchecked' => [
                            [
                                'field' => 'volume',
                                'value' => 1
                            ]
                        ]
                    ]
                ],
                    'volume' => [
                        'conditions' => [
                            'readonly' => [
                                [
                                    'field' => 'reverse_sticker',
                                    'value' => 1
                                ]
                            ],
                            'unchecked' => [
                                [
                                    'field' => 'reverse_sticker',
                                    'value' => 1
                                ]
                            ]
                        ]
                    ]
                ]
            ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => 3819,
            'calculator_fields_config_id' => $config->getKey()
        ]);

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'checkboxes_options',
            'value' => [
                'small_objects' => [
                    'conditions' => [
                        'unchecked' => [
                            [
                                'field' => 'mounting_film',
                                'value' => 0
                            ]
                        ],
                        'readonly' => [
                            [
                                'field' => 'mounting_film',
                                'value' => 0
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => 3822,
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
