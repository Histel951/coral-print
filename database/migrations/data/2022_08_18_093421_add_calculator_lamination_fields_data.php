<?php

use App\Models\PivotCalculatorLamination;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $laminations = [
            'calculators' => [3820, 3822, 3823, 3824],
            'laminations' => [45, 46, 47, 48, 49, 50, 51],
            'print_id' => [14, 17]
        ];

        foreach ($laminations['calculators'] as $calculatorId) {
            foreach ($laminations['laminations'] as $laminationId) {
                foreach ($laminations['print_id'] as $printId) {
                    PivotCalculatorLamination::query()->create([
                        'print_id' => $printId,
                        'calculator_id' => $calculatorId,
                        'lamination_id' => $laminationId
                    ]);
                }
            }
        }

        $config = \App\Models\CalculatorFieldsConfig::query()->find(17)->value;
        unset($config['lam']['conditions']['visible']);

        \App\Models\CalculatorFieldsConfig::query()->find(17)->update([
            'value' => $config
        ]);
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
