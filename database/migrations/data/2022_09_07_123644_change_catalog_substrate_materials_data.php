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
        // Обложка - 44, 45, 46
        // Блок - 26, 27, 29, 30

        \App\Models\PivotCalculatorMaterial::query()->where('calculator_id', 3866)->delete();

        $materials = [1 => [44, 45, 46], 2 => [26, 27, 29, 30]];

        foreach ($materials as $calculatorSubId => $itemMaterials) {
            foreach ($itemMaterials as $materialId) {
                \App\Models\PivotCalculatorMaterial::query()->create([
                    'calculator_id' => 3866,
                    'material_id' => $materialId,
                    'calculator_sub_id' => $calculatorSubId
                ]);
            }
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
