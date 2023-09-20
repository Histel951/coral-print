<?php

use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Models\PivotCalculatorFoiling;
use App\Models\PivotCalculatorMaterial;
use App\Models\PrintSize;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $allMaterials = [26, 27, 28, 29, 30, 43, 44, 45, 46, 78, 79, 80, 81, 82, 144, 83, 84, 143, 85, 86, 87, 88, 89, 37, 40, 90, 38, 41, 91];

        PrintSize::query()->find(76)->update([
            'name' => 'А3 (297x420 мм)',
            'short_name' => '297x420',
            'width' => 297,
            'height' => 420
        ]);

        PivotCalculatorFoiling::query()
            ->where('calculator_id', 3873)
            ->where('foiling_id', 26)
            ->delete();

        $calculators = CalculatorType::query()->where('name', 'booklets')->first()->calculators;

        $calculators->each(function (Calculator $calculator) use ($allMaterials) {
            $calculator->materials();

            PivotCalculatorMaterial::query()->where('calculator_id', $calculator->id)->delete();

            $calculator->materials()->sync($allMaterials);
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
