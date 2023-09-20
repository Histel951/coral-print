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
        $businessCardCalculators = CalculatorType::query()->where('name', 'businessCards')->first()
            ->calculators();

        $businessCardCalculators->each(
            fn (Calculator $calculator) => PivotWorkAdditional::query()
                ->where('calculator_id', $calculator->id)
                ->where('print_form_id', 55)
                ->whereIn('work_additional_id', [46, 51])
                ->delete()
        );

        $businessCardCalculators->each(
            fn (Calculator $calculator) => PivotWorkAdditional::query()->create([
                'calculator_id' => $calculator->id,
                'print_form_id' => 55,
                'work_additional_id' => 56
            ])
        );
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
