<?php

use App\Models\PivotCalculatorMaterial;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $data = [
            'calculators' => [3820, 3822, 3823, 3824],
            'materials' => [47, 53, 54, 55, 142, 76, 56, 65, 66, 71, 72, 69, 67, 73, 74]
        ];

        foreach ($data['calculators'] as $calculatorId) {
            foreach ($data['materials'] as $materialId) {
                PivotCalculatorMaterial::query()->create([
                    'calculator_id' => $calculatorId,
                    'material_id' => $materialId,
                    'print_id' => 17,
                    'is_white_print' => null
                ]);
            }
        }

        DB::update("update pivot_calculator_materials set is_white_print = null
                                                      where calculator_id in (3820, 3824, 3823, 3822) and print_id = 17;");

        $materialCalculator = [
            'materials' => [47, 53, 54, 55, 142, 76, 56, 65, 66, 71, 72, 69, 67, 73, 74],
            'calculators' => [3820, 3823, 3824, 3822],
            'prints' => [14]
        ];

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

        $values = [
            3820 => [145, 146, 147, 148, 149, 150, 151]
        ];

        Schema::disableForeignKeyConstraints();
        foreach ($values as $calculatorId => $materials) {
            foreach ($materials as $materialId) {
                PivotCalculatorMaterial::query()->create([
                    'calculator_id' => $calculatorId,
                    'material_id' => $materialId,
                    'is_white_print' => true,
                    'print_id' => 14
                ]);
            }
        }
        Schema::enableForeignKeyConstraints();
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
