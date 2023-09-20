<?php

use App\Models\Lamination;
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
        $whitePrintMaterials = [
            'materials' => [61, 22, 145, 146, 147, 148, 149, 150, 151],
            'calculators' => [3818, 3820, 3823, 3829, 3819],
            'prints' => [14, 17]
        ];

        foreach ($whitePrintMaterials['calculators'] as $calculatorId) {
            foreach ($whitePrintMaterials['materials'] as $materialId) {
                foreach ($whitePrintMaterials['prints'] as $printId) {
                    PivotCalculatorMaterial::query()->create([
                        'calculator_id' => $calculatorId,
                        'material_id' => $materialId,
                        'is_white_print' => 1,
                        'print_id' => $printId
                    ]);
                }
            }
        }

        $nonePrintMaterials = [
            'calculators' => [3820, 3822, 3823, 3824],
            'materials' => [47, 53, 54, 55, 142, 76, 56, 65, 66, 71, 72, 69, 67, 73, 74],
            'prints' => [17]
        ];

        foreach ($nonePrintMaterials['calculators'] as $calculatorId) {
            foreach ($nonePrintMaterials['materials'] as $materialId) {
                foreach ($nonePrintMaterials['prints'] as $printId) {
                    PivotCalculatorMaterial::query()->create([
                        'calculator_id' => $calculatorId,
                        'material_id' => $materialId,
                        'print_id' => $printId
                    ]);
                }
            }
        }

        Lamination::query()->find(45)->update([
            'name' => 'Без ламинации'
        ]);

        Lamination::query()->find(46)->update([
            'name' => 'Матовая (80 мкр)'
        ]);

        $config = \App\Models\CalculatorFieldsConfig::query()->find(20)->value;
        // {"field": "white_print", "value": 1, "selected_value": 1}
        $config['lam']['conditions']['selected'] = [...$config['lam']['conditions']['selected'],
            ['field' => 'white_print', 'value' => 1, 'selected_value' => 1]];
        // {"field": "white_print", "value": 1}
        $config['lam']['conditions']['readonly'] = [...$config['lam']['conditions']['readonly'],
            ['field' => 'white_print', 'value' => 1, 'priority' => 100]
        ];

        // {"field": "white_print", "value": 1, "priority": 2, "selected_value": 1}
        $config['lam']['conditions']['selected'] = [...$config['lam']['conditions']['selected'],
            ['field' => 'white_print', 'value' => 1, 'priority' => 2, 'selected_value' => 1]
        ];

        \App\Models\CalculatorFieldsConfig::query()->find(20)->update([
            'value' => $config
        ]);

        \App\Models\PivotWorkAdditional::query()->find(60)->delete();

        \App\Models\PivotWorkAdditional::query()->create([
            'work_additional_id' => 50,
            'cutting_id' => 4,
            'print_type_id' => 15
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
