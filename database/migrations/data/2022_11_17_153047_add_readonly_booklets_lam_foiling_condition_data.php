<?php

use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\Check;
use App\Models\PivotCalculatorChecks;
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
        $calculator = Calculator::query()->where('name', 'VIP Буклет')->first();

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'lam' => [
                    'conditions' => [
                        'readonly' => [
                            [
                                'field' => 'foiling',
                                'value' => 27
                            ],
                            [
                                'field' => 'varnish_face',
                                'value' => 1
                            ],
                            [
                                'field' => 'varnish_back',
                                'value' => 1
                            ]
                        ],
                        'selected' => [
                            [
                                'field' => 'foiling',
                                'value' => 27,
                                'selected_value' => 123
                            ],
                            [
                                'field' => 'varnish_face',
                                'value' => 1,
                                'selected_value' => 123
                            ],
                            [
                                'field' => 'varnish_back',
                                'value' => 1,
                                'selected_value' => 123
                            ]
                        ],
                    ]
                ]
            ]
        ]);

        $checks = [
            [
                'values' => ['lam' => [45, 113, 115]],
                'identifiers' => [
                    'print_specie_id' => 23,
                    'lam' => 123
                ],
                'data' => [
                    'material' => [43, 44, 45, 46]
                ]
            ],
            [
                'values' => ['lam' => [45, 113, 115]],
                'identifiers' => [
                    'print_specie_id' => 24,
                    'lam' => 123
                ],
                'data' => ['material' => [43, 44, 45, 46]]
            ],
            [
                'values' => ['lam' => [45, 113, 115]],
                'identifiers' => [
                    'print_specie_id' => 25,
                    'lam' => 123
                ],
                'data' => ['material' => [43, 44, 45, 46]]
            ]
        ];

        foreach ($checks as $check) {
            $newCheck = Check::query()->create([
                'name' => 'material',
                'checks' => $check['values'],
                'identifiers' => $check['identifiers'],
                'data' => $check['data']
            ]);

            PivotCalculatorChecks::query()->create([
                'calculator_id' => $calculator->getKey(),
                'check_id' => $newCheck->getKey()
            ]);
        }

        $laminationCheckDeps = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'material' => [
                    'checks' => [
                        [
                            'deps' => ['width', 'height', 'print_select', 'material', 'lam'],
                            'disable' => 'readOnlyItemsIn'
                        ]
                    ]
                ]
            ]
        ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->getKey(),
            'calculator_fields_config_id' => $laminationCheckDeps->getKey()
        ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->getKey(),
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
