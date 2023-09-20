<?php

use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Models\PivotWorkAdditional;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        PivotWorkAdditional::query()
            ->where('calculator_id', 3832)
            ->whereIn('work_additional_id', [28, 32])
            ?->delete();

        $allVisitkyCalculators = CalculatorType::query()->where('name', 'businessCards')->first()->calculators();

        // 44, 45, 48 - сложная
        $allVisitkyCalculators->each(function (Calculator $calculator): void {
            // printForms
            foreach ([54, 55, 56] as $printFormId) {
                // workId
                foreach ([44, 45] as $workAdditionalId) {
                    PivotWorkAdditional::query()->create([
                        'work_additional_id' => $workAdditionalId,
                        'calculator_id' => $calculator->id,
                        'print_form_id' => $printFormId
                    ]);
                }
            }

            // workId
            foreach ([44, 45, 48] as $workAdditionalId) {
                PivotWorkAdditional::query()->create([
                    'work_additional_id' => $workAdditionalId,
                    'calculator_id' => $calculator->id,
                    'print_form_id' => 57
                ]);
            }
        });

        PivotWorkAdditional::query()
            ->whereIn('calculator_id', [3831, 3832])
            ->where('work_additional_id', 56)
            ->delete();
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
