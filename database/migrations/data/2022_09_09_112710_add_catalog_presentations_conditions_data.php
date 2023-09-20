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
        $newConfig = \App\Models\CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'material_wrapper' => [
                    'conditions' => [
                        'readonlyIn' => [
                            [
                                'change_field' => 'color_substrate_select',
                                'field' => 'plastic_substrate_select',
                                'values' => [3],
                                'value' => 9
                            ],
                            [
                                'change_field' => 'lam_substrate_select',
                                'field' => 'plastic_substrate_select',
                                'values' => [3],
                                'value' => 111
                            ],
                            [
                                'change_field' => 'material_substrate_select',
                                'field' => 'plastic_substrate_select',
                                'values' => [3],
                                'value' => 99
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        \App\Models\PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => 3858,
            'calculator_fields_config_id' => $newConfig->getKey()
        ]);
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
