<?php

use App\Models\Calculator;
use App\Models\PivotCalculatorFoiling;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $allCalculators = Calculator::query()->whereIn('id', [3818, 3821]);

        $foilingIds = [25, 26, 27];

        PivotCalculatorFoiling::query()
            ->whereNotIn('foiling_id', $foilingIds)
            ->where('calculator_id', [3818, 3821])
            ->delete();

        foreach ($foilingIds as $foilingId) {
            $allCalculators->each(function (Calculator $calculator) use ($foilingId): void {
                PivotCalculatorFoiling::query()->create([
                    'calculator_id' => $calculator->id,
                    'foiling_id' => $foilingId
                ]);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
    }
};
