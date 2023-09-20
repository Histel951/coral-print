<?php

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
        $materialCalculator = [
            'materials' => [47, 53, 54, 55, 142, 76, 56, 65, 66, 71, 72, 69, 67, 73, 74],
            'calculators' => [3818, 3820, 3823, 3829, 3819],
            'prints' => [14]
        ];

        foreach ($materialCalculator['calculators'] as $calculatorId) {
            foreach ($materialCalculator['prints'] as $printId) {
                PivotCalculatorMaterial::query()->where([
                    'calculator_id' => $calculatorId,
                    'print_id' => $printId
                ])->delete();
            }
        }

        foreach ($materialCalculator['calculators'] as $calculatorId) {
            foreach ($materialCalculator['materials'] as $materialId) {
                foreach ($materialCalculator['prints'] as $printId) {
                    PivotCalculatorMaterial::query()->create([
                        'calculator_id' => $calculatorId,
                        'print_id' => $printId,
                        'material_id' => $materialId
                    ]);
                }
            }
        }

        $whitePrintMaterials = [
            'materials' => [61, 22, 145, 146, 147, 148, 149, 150, 151],
            'calculators' => [3818, 3820, 3823, 3829, 3819],
            'prints' => [17]
        ];

        foreach ($whitePrintMaterials['calculators'] as $calculatorId) {
            foreach ($whitePrintMaterials['prints'] as $printId) {
                PivotCalculatorMaterial::query()->where([
                    'calculator_id' => $calculatorId,
                    'print_id' => $printId
                ])->delete();
            }
        }

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
