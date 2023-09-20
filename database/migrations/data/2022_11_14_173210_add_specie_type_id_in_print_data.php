<?php

use App\Models\Calculator;
use App\Models\CalculatorType;
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
        $calculators = CalculatorType::query()->where('name', 'booklets')->first()
            ->calculators()->whereNot('id', [3873, 3867]);

        $calculators->each(fn (Calculator $calculator) => PivotCalculatorSpecieType::query()->create([
            'calculator_id' => $calculator->id,
            'specie_type_id' => 30,
            'print_id' => 126
        ]));
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
