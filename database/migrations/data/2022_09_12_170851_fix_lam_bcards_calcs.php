<?php

use App\Models\CalculatorType;
use App\Models\PivotCalculatorLamination;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $calcs = CalculatorType::where('name', 'businessCards')->get()->first()->calculators;

        foreach ($calcs as $calc) {
            if (PivotCalculatorLamination::where('calculator_id', $calc->id)->where('lamination_id', 118)->delete()) {
                PivotCalculatorLamination::query()->create([
                    'calculator_id' => $calc->id,
                    'lamination_id' => 118,
                ]);
            }
        }
        Cache::flush();
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
