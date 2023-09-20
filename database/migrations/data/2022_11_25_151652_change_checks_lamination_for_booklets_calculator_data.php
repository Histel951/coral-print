<?php

use App\Models\Calculator;
use App\Models\Check;
use App\Models\PivotCalculatorChecks;
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

        Check::query()->whereNotNull('data')->delete();

        $checks = [
            [
                'values' => ['lam' => [1]],
                'identifiers' => [
                    'print_specie_id' => 23,
                    'lam' => 123
                ],
                'data' => [
                    'material' => [43, 44, 45, 46]
                ]
            ],
            [
                'values' => ['lam' => [1]],
                'identifiers' => [
                    'print_specie_id' => 24,
                    'lam' => 123
                ],
                'data' => ['material' => [90, 37, 40]]
            ],
            [
                'values' => ['lam' => [1]],
                'identifiers' => [
                    'print_specie_id' => 25,
                    'lam' => 123
                ],
                'data' => ['material' => [91, 38, 41]]
            ],
            [
                'values' => ['lam' => [1]],
                'identifiers' => [
                    'print_specie_id' => 23,
                    'lam' => 113
                ],
                'data' => [
                    'material' => [43, 44, 45, 46]
                ]
            ],
            [
                'values' => ['lam' => [1]],
                'identifiers' => [
                    'print_specie_id' => 24,
                    'lam' => 113
                ],
                'data' => ['material' => [90, 37, 40]]
            ],
            [
                'values' => ['lam' => [1]],
                'identifiers' => [
                    'print_specie_id' => 25,
                    'lam' => 113
                ],
                'data' => ['material' => [91, 38, 41]]
            ],
            [
                'values' => ['lam' => [1]],
                'identifiers' => [
                    'print_specie_id' => 23,
                    'lam' => 115
                ],
                'data' => [
                    'material' => [43, 44, 45, 46]
                ]
            ],
            [
                'values' => ['lam' => [1]],
                'identifiers' => [
                    'print_specie_id' => 24,
                    'lam' => 115
                ],
                'data' => ['material' => [90, 37, 40]]
            ],
            [
                'values' => ['lam' => [1]],
                'identifiers' => [
                    'print_specie_id' => 25,
                    'lam' => 115
                ],
                'data' => ['material' => [91, 38, 41]]
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
