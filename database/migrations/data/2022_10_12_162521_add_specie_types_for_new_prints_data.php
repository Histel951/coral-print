<?php

use App\Models\PivotCalculatorPrints;
use App\Models\PivotCalculatorSpecieType;
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
        PivotCalculatorSpecieType::query()->where('calculator_id', 3832)->delete();

        PivotCalculatorPrints::query()->where('calculator_id', 3832)->each(
            fn (PivotCalculatorPrints $calculatorPrints) => PivotCalculatorSpecieType::query()->create([
                'print_id' => $calculatorPrints->print_id,
                'calculator_id' => 3832,
                'specie_type_id' => 30
            ])
        );

        PivotWorkAdditional::query()->create([
            'calculator_id' => 3831,
            'work_additional_id' => 56
        ]);
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
