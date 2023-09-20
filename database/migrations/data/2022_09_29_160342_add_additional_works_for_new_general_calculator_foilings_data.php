<?php

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
        $calculatorFoilingWorks = [
            3818 => [
                'foilings' => [26, 27],
                'works' => [32, 37]
            ],
            3821 => [
                'foilings' => [26, 27],
                'works' => [32, 37]
            ]
        ];

        foreach ($calculatorFoilingWorks as $calculatorId => $item) {
            foreach ($item['foilings'] as $foilingId) {
                foreach ($item['works'] as $workId) {
                    PivotWorkAdditional::query()->create([
                        'calculator_id' => $calculatorId,
                        'foiling_id' => $foilingId,
                        'work_additional_id' => $workId
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
