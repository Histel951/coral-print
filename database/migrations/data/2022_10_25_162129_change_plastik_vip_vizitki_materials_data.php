<?php

use App\Models\CalculatorFieldsConfig;
use App\Models\PivotCalculatorFieldsConfig;
use App\Models\PivotCalculatorMaterial;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        PivotCalculatorMaterial::query()->where('calculator_id', 3833)->delete();

        $materials = [98, 193];

        foreach ($materials as $materialId) {
            PivotCalculatorMaterial::query()->create([
                'calculator_id' => 3833,
                'material_id' => $materialId
            ]);
        }

        $materialLabelConfig = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'material' => [
                    'label' => 'Материал'
                ],
            ]
        ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_fields_config_id' => $materialLabelConfig->getKey(),
            'calculator_id' => 3833
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
