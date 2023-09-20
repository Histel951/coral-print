<?php

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
            'calculator_sub_ids' => [1],
            'laminations' => [
                // lamination => [work_additional => repeats]
                117 => [32 => 1, 37 => 2]
            ]
        ];

        foreach ($laminations['calculator_sub_ids'] as $calculatorSubId) {
            foreach ($laminations['laminations'] as $laminationId => $item) {
                foreach ($item as $workId => $repeats) {
                    \App\Models\PivotWorkAdditional::query()->create([
                        'calculator_sub_id' => $calculatorSubId,
                        'lamination_id' => $laminationId,
                        'work_additional_id' => $workId,
                        'repeat' => $repeats
                    ]);
                }
            }
        }

        $changeRepeatsLaminations = [
            115 => [
                'repeats' => 2,
                'calculator_sub_id' => [1, 3],
                'work_additional_id' => 28
            ],
            117 => [
                'repeats' => 2,
                'calculator_sub_id' => [3],
                'work_additional_id' => 37
            ],
            113 => [
                'repeats' => 2,
                'calculator_sub_id' => [3],
                'work_additional_id' => 37
            ]
        ];

        foreach ($changeRepeatsLaminations as $laminationId => $item) {
            \App\Models\PivotWorkAdditional::query()
                ->where('lamination_id', $laminationId)
                ->whereIn('calculator_sub_id', $item['calculator_sub_id'])
                ->where('work_additional_id', $item['work_additional_id'])
                ->update([
                    'repeat' => $item['repeats']
                ]);
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
