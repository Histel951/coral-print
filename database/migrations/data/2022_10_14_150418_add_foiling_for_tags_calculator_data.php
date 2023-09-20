<?php

use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\CalculatorType;
use App\Models\PivotCalculatorFieldsConfig;
use App\Models\PivotCalculatorFoiling;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $fields = CalculatorFieldsConfig::query()->find(41)?->value;

        if (!$fields) {
            return;
        }

        $allLabelCalculators = CalculatorType::query()->where('name', 'labels')->first()->calculators;

        $key = array_search('foiling_back', $fields);
        unset($fields[$key]);

        CalculatorFieldsConfig::query()->find(41)->update([
            'value' => array_values($fields)
        ]);

        $allFoilings = [25, 26, 27];
        foreach ($allFoilings as $foilingId) {
            $allLabelCalculators->each(fn (Calculator $calculator) => PivotCalculatorFoiling::query()->create([
                'calculator_id' => $calculator->id,
                'foiling_id' => $foilingId
            ]));
        }

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
