<?php

use App\Models\PivotCalculatorLamination;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculatorLaminations = [
            3868 => [45, 113, 115, 117],
            3869 => [45, 113, 115, 117],
            3870 => [45, 113, 115, 117],
            3871 => [45, 113, 115, 117],
            3872 => [45, 113, 115, 117],
            3873 => [45, 113, 115, 117],
        ];

        foreach ($calculatorLaminations as $calculatorId => $laminations) {
            PivotCalculatorLamination::query()->where('calculator_id', $calculatorId)->delete();

            foreach ($laminations as $laminationId) {
                PivotCalculatorLamination::query()->create([
                    'calculator_id' => $calculatorId,
                    'lamination_id' => $laminationId
                ]);
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
