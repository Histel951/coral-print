<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\CalculatorFieldsConfig;
use App\Models\Calculator;
use App\Models\PivotCalculatorFieldsConfig;
use App\Models\CalculatorType;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $allLabelCalculators = CalculatorType::query()->where('name', 'labels')->first()->calculators;

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'color' => [
                    'conditions' => [
                        'readonly' => [
                            [
                                'field' => 'foiling_face',
                                'value' => 26,
                                'selected_value' => 16
                            ]
                        ],
                        'selected' => [
                            [
                                'field' => 'foiling_face',
                                'value' => 26,
                                'selected_value' => 16
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $allLabelCalculators->each(fn (Calculator $calculator) => PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_fields_config_id' => $config->getKey()
        ]));

        $materialCondition = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'material' => [
                    'conditions' => [
                        'readonlyItemsIn' => [
                            [
                                'disabled_items' => [79, 82, 84, 85, 87, 88, 89],
                                'values' => [26],
                                'change_field' => 'material',
                                'field' => 'foiling_face',
                                'value' => 44
                            ],
                            [
                                'disabled_items' => [79, 82, 84, 85, 86, 87, 88, 89],
                                'values' => [27],
                                'change_field' => 'material',
                                'field' => 'foiling_face',
                                'value' => 44
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $allLabelCalculators->each(fn (Calculator $calculator) => PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_fields_config_id' => $materialCondition->getKey()
        ]));

        $laminationConditions = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'lam' => [
                    'conditions' => [
                        'readonlyMany' => [
                            [
                                'values' => [
                                    'material' => 44,
                                    'foiling_face' => 26
                                ]
                            ],
                            [
                                'values' => [
                                    'material' => 45,
                                    'foiling_face' => 26
                                ]
                            ],
                            [
                                'values' => [
                                    'material' => 46,
                                    'foiling_face' => 26
                                ]
                            ],
                            [
                                'values' => [
                                    'material' => 86,
                                    'foiling_face' => 26
                                ]
                            ],
                            [
                                'values' => [
                                    'material' => 44,
                                    'foiling_face' => 27
                                ]
                            ],
                            [
                                'values' => [
                                    'material' => 45,
                                    'foiling_face' => 27
                                ]
                            ],
                            [
                                'values' => [
                                    'material' => 46,
                                    'foiling_face' => 27
                                ]
                            ],
                        ],
                        'selectedMany' => [
                            [
                                'values' => [
                                    'material' => 44,
                                    'foiling_face' => 26
                                ],
                                'value' => 117
                            ],
                            [
                                'values' => [
                                    'material' => 45,
                                    'foiling_face' => 26
                                ],
                                'value' => 117
                            ],
                            [
                                'values' => [
                                    'material' => 46,
                                    'foiling_face' => 26
                                ],
                                'value' => 117
                            ],
                            [
                                'values' => [
                                    'material' => 86,
                                    'foiling_face' => 26
                                ],
                                'value' => 111
                            ],
                            [
                                'values' => [
                                    'material' => 44,
                                    'foiling_face' => 27,
                                ],
                                'value' => 117
                            ],
                            [
                                'values' => [
                                    'material' => 45,
                                    'foiling_face' => 27,
                                ],
                                'value' => 117
                            ],
                            [
                                'values' => [
                                    'material' => 46,
                                    'foiling_face' => 27
                                ],
                                'value' => 117
                            ],
                        ]
                    ]
                ]
            ]
        ]);

        $allLabelCalculators->each(fn (Calculator $calculator) => PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_fields_config_id' => $laminationConditions->getKey()
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
