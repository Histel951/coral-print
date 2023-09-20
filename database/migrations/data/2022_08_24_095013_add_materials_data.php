<?php

use App\Models\PivotCalculatorMaterial;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        PivotCalculatorMaterial::query()
            ->whereIn('calculator_id', [3820, 3822, 3823, 3824])->delete();

        $data = [
            [
                'calculators' => [3820, 3822, 3823, 3824],
                'materials' => [61, 22, 145, 146, 147, 148, 149, 150, 151],
                'print_id' => 14
            ],
        ];

        foreach ($data as $item) {
            foreach ($item['calculators'] as $calculatorId) {
                foreach ($item['materials'] as $materialId) {
                    PivotCalculatorMaterial::query()->create([
                        'calculator_id' => $calculatorId,
                        'material_id' => $materialId,
                        'print_id' => $item['print_id'],
                        'is_white_print' => true
                    ]);
                }
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
