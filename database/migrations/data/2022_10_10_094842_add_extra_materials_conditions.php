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
        PivotCalculatorMaterial::query()
            ->where('calculator_id', 3832)
            ->whereNotIn('material_id', [46, 86])
            ->delete();

        $allPrints = [null, 125, 126];

        foreach ($allPrints as $print) {
            PivotCalculatorMaterial::query()->create([
                'material_id' => 86,
                'print_id' => $print,
                'calculator_id' => 3832
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
