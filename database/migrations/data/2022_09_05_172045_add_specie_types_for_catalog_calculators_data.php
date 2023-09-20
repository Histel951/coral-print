<?php

use App\Models\PivotCalculatorSpecieType;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculators = [3866, 3856, 3860, 3858];

        $correctSpecieTypes = PivotCalculatorSpecieType::query()
            ->where('calculator_id', 3859)
            ->where('calculator_sub_id', 3)
            ->get();

        foreach ($calculators as $calculatorId) {
            PivotCalculatorSpecieType::query()
                ->where('calculator_id', $calculatorId)
                ->where('calculator_sub_id', 3)
                ->delete();

            $correctSpecieTypes->map(
                fn (PivotCalculatorSpecieType $pivotCalculatorSpecieType) => PivotCalculatorSpecieType::query()->create([
                    'calculator_id' => $calculatorId,
                    'specie_type_id' => $pivotCalculatorSpecieType->specie_type_id,
                    'print_id' => $pivotCalculatorSpecieType->print_id,
                    'is_duplex' => $pivotCalculatorSpecieType->is_duplex,
                    'calculator_sub_id' => $pivotCalculatorSpecieType->calculator_sub_id,
                    'is_white_print' => null
                ])
            );
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
