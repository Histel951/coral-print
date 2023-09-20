<?php

use App\Models\PivotCalculatorLamination;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ([45, 118, 119, 120] as $lam) {
            PivotCalculatorLamination::query()->create([
                'calculator_id' => 3834,
                'lamination_id' => $lam,
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
        foreach ([45, 118, 119, 120] as $lam) {
            PivotCalculatorLamination::query()->where([
                'calculator_id' => 3834,
                'lamination_id' => $lam,
            ])->delete();
        }
    }
};
