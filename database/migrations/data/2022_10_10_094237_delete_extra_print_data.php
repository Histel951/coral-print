<?php

use App\Models\PivotCalculatorPrints;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        PivotCalculatorPrints::query()
            ->where('calculator_id', 3832)
            ->where('print_id', 124)
            ->delete();
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
