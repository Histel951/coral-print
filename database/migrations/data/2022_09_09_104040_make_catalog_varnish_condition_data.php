<?php

use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $allCalculators = \App\Models\Calculator::query()->where('calculator_type_id', 3854)->pluck('id');

        $newConfig = \App\Models\CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'material_wrapper' => [
                    'conditions' => [
                        'readonlyIn' => [
                            [
                                'change_field' => 'lam_cover_select',
                                'field' => 'varnish_cover_select',
                                'values' => [1],
                                'value' => 116
                            ],
                            [
                                'change_field' => 'varnish_cover_select',
                                'field' => 'material_cover_select',
                                'values' => [86],
                                'value' => 0
                            ]
                        ],
                    ]
                ]
            ]
        ]);

        $allCalculators->map(fn (int $calculatorId) => \App\Models\PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculatorId,
            'calculator_fields_config_id' => $newConfig->getKey()
        ]));
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
