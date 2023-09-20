<?php

use App\Models\Calculator;
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
        $substrateMaterials = [26, 27, 28, 29, 30, 43, 44, 45, 46, 78, 79, 80, 81, 144, 82, 143, 83, 84, 85, 86, 87, 88, 89];

        $calculators = Calculator::query()->where('calculator_type_id', 3854)->get();

        $calculators->map(function (Calculator $calculator) use ($substrateMaterials) {
            if ($calculator->id !== 3866) {
                foreach ($substrateMaterials as $materialId) {
                    PivotCalculatorMaterial::query()->create([
                        'calculator_sub_id' => 3,
                        'calculator_id' => $calculator->id,
                        'material_id' => $materialId
                    ]);
                }
            }
        });
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
