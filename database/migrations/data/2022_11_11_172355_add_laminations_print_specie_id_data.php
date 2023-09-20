<?php

use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\CalculatorType;
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
        $calculators = CalculatorType::query()->where('name', 'booklets')->first()->calculators;

        $checks = [
            [
                'values' => ['material' => [43, 44, 45, 46]],
                'identifiers' => [
                    'print_specie_id' => 23
                ],
            ],
            [
                'values' => ['material' => [90, 37, 40]],
                'identifiers' => [
                    'print_specie_id' => 24
                ]
            ],
            [
                'values' => ['material' => [91, 38, 41]],
                'identifiers' => [
                    'print_specie_id' => 25
                ]
            ]
        ];

        foreach ($checks as $check) {
            $newCheck = Check::query()->create([
                'name' => 'lam',
                'checks' => $check['values'],
                'identifiers' => $check['identifiers']
            ]);

            $calculators->each(fn (Calculator $calculator) => PivotCalculatorChecks::query()->create([
                'calculator_id' => $calculator->id,
                'check_id' => $newCheck->getKey()
            ]));
        }

        $laminationCheckDeps = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'lam' => [
                    'checks' => [
                        [
                            'deps' => ['width', 'height', 'print_select', 'material', 'varnish_face', 'varnish_back'],
                            'disable' => 'readOnly'
                        ]
                    ],
                    'default' => 45
                ]
            ]
        ]);

        $calculators->each(fn (Calculator $calculator) => PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_fields_config_id' => $laminationCheckDeps->getKey()
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
