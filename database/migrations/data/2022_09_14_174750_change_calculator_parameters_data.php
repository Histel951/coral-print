<?php

use App\Models\Calculator;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculator = Calculator::query()->where('name', 'Каталоги на клею (КБС)')->first();
        $calculatorParameters = $calculator->parameters;

        $calculatorParameters['is_not_wide_block'] = true;
        $calculatorParameters['is_two_side_print'] = false;
        $calculator->update([
            'parameters' => $calculatorParameters
        ]);

        $calculator = Calculator::query()->where('calculator_type_id', 3854)->latest()->first();
        $calculatorParameters = $calculator->parameters;

        $calculatorParameters['is_not_wide_block'] = true;
        $calculatorParameters['is_two_side_print'] = false;
        $calculator->update([
            'parameters' => $calculatorParameters
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
