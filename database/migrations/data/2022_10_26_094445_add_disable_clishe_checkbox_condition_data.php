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
        $calculators = [3836, 3833];

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'checkboxes_options',
            'value' => [
                'cliche' => [
                    'conditions' => [
                        'readonlyMany' => [
                            [
                                'values' => [
                                    'embossing_face1_select_visitki_vip_face_select' => 28,
                                    'embossing_face2_select_visitki_vip_face_select' => 28,
                                    'embossing_back1_select_visitki_vip_back_select' => 28,
                                    'embossing_back2_select_visitki_vip_back_select' => 28
                                ]
                            ]
                        ]
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
    public function down()
    {
        //
    }
};
