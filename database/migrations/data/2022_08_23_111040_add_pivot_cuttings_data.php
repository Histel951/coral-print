<?php

use App\Models\PivotCalculatorCutting;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $data = [
            [
                'calculators' => [3819, 3821],
                'cuttings' => [1, 2, 4],
                'is_volume' => 1
            ]
        ];

        foreach ($data as $item) {
            foreach ($item['calculators'] as $calculatorId) {
                foreach ($item['cuttings'] as $cuttingId) {
                    PivotCalculatorCutting::query()->create([
                        'calculator_id' => $calculatorId,
                        'cutting_id' => $cuttingId,
                        'is_volume' => $item['is_volume']
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
    public function down(): void
    {
        //
    }
};
