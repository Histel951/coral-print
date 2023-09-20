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
        $calculators = CalculatorType::query()->where('name', 'labels')->first()->calculators;

        $foilingWorksAdditionals = [
            26 => [77, 78],
            27 => [77, 79]
        ];

        foreach ($foilingWorksAdditionals as $foilingId => $worksAdditionals) {
            foreach ($worksAdditionals as $workAdditionalId) {
                $calculators->each(fn (Calculator $calculator) => PivotWorkAdditional::query()->create([
                    'foiling_id' => $foilingId,
                    'work_additional_id' => $workAdditionalId,
                    'calculator_id' => $calculator->id
                ]));
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
