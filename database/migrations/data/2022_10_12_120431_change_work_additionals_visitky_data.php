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
        $allVisitkyCalculators = CalculatorType::query()->where('name', 'businessCards')->first()->calculators();

        $allVisitkyCalculators->each(function (Calculator $calculator): void {
            // printForms
            foreach ([54, 55, 56] as $printFormId) {
                // workId
                foreach ([44, 45] as $workAdditionalId) {
                    PivotWorkAdditional::query()
                        ->where('work_additional_id', $workAdditionalId)
                        ->where('calculator_id', $calculator->id)
                        ->where('print_form_id', $printFormId)
                        ->delete();
                }

                foreach ([46, 51] as $workAdditionalId) {
                    PivotWorkAdditional::query()->create([
                        'work_additional_id' => $workAdditionalId,
                        'calculator_id' => $calculator->id,
                        'print_form_id' => $printFormId
                    ]);
                }
            }

            // workId
            foreach ([44, 45, 48] as $workAdditionalId) {
                PivotWorkAdditional::query()
                    ->where('work_additional_id', $workAdditionalId)
                    ->where('calculator_id', $calculator->id)
                    ->where('print_form_id', 57)
                    ->delete();
            }

            foreach ([46, 51, 48] as $workAdditionalId) {
                PivotWorkAdditional::query()->create([
                    'work_additional_id' => $workAdditionalId,
                    'calculator_id' => $calculator->id,
                    'print_form_id' => 57
                ]);
            }
        });
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
