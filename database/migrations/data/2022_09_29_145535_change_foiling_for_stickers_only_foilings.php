<?php

use App\Models\PivotCalculatorFoiling;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        PivotCalculatorFoiling::query()->where('calculator_id', 3821)->delete();

        $foilings = [26, 27];

        foreach ($foilings as $foiling) {
            PivotCalculatorFoiling::query()->create([
                'calculator_id' => 3821,
                'foiling_id' => $foiling
            ]);
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
