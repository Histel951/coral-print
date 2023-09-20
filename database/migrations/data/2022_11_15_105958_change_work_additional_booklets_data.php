<?php

use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Models\Lamination;
use App\Models\PivotCalculatorLamination;
use App\Models\PivotLaminationType;
use App\Models\PivotWorkAdditional;
use App\Models\WorkAdditional;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $softTouch30_1_0 = Lamination::query()->create([
            'name' => 'Soft touch (30 мкр) 1+0'
        ]);

        $softTouch30_1_1 = Lamination::query()->create([
            'name' => 'Soft touch (30 мкр) 1+1'
        ]);

        PivotCalculatorLamination::query()->where('calculator_id', 3867)
            ->whereIn('lamination_id', [116, 117])->delete();

        PivotCalculatorLamination::query()->create([
            'calculator_id' => 3867,
            'lamination_id' => $softTouch30_1_0->getKey()
        ]);

        PivotCalculatorLamination::query()->create([
            'calculator_id' => 3867,
            'lamination_id' => $softTouch30_1_1->getKey()
        ]);

        $calculators = CalculatorType::query()->where('name', 'booklets')
            ->first()->calculators()->whereNot('id', 3867);


        $calculators->each(function (Calculator $calculator) use ($softTouch30_1_0) {
            PivotCalculatorLamination::query()->where('calculator_id', $calculator->id)
                ->where('lamination_id', 116)->delete();

            PivotCalculatorLamination::query()->create([
                'calculator_id' => $calculator->id,
                'lamination_id' => $softTouch30_1_0->getKey()
            ]);
        });

        PivotLaminationType::query()->create([
            'lamination_type_id' => 3,
            'lamination_id' => $softTouch30_1_0->getKey()
        ]);

        PivotLaminationType::query()->create([
            'lamination_type_id' => 3,
            'lamination_id' => $softTouch30_1_1->getKey()
        ]);

        $lam25_700 = WorkAdditional::query()->where('code', '#лам25(700)')?->first()?->getKey() ?? 28;
        $lam25_900 = WorkAdditional::query()->where('code', '#лам25(900)')?->first()?->getKey() ?? 28;
        $softTouch_700 = WorkAdditional::query()->where('code', '#ламsoftYDFM(700)')?->first()?->getKey() ?? 32;
        $softTouch_900 = WorkAdditional::query()->where('code', '#ламsoftYDFM(900)')?->first()?->getKey() ?? 32;

        // print_specie => [lamination_id => [work_id => repeats]]
        $printSpecieWorkAdditional = [
            23 => [
                112 => [
                    32 => 1,
                    28 => 1
                ],
                113 => [
                    32 => 1,
                    28 => 2
                ],
                114 => [
                    32 => 1,
                    28 => 1
                ],
                115 => [
                    32 => 1,
                    28 => 2
                ],
                $softTouch30_1_0->getKey() => [
                    32 => 1,
                    37 => 1,
                ],
                $softTouch30_1_1->getKey() => [
                    32 => 1,
                    37 => 2,
                ]
            ],
            24 => [
                112 => [
                    32 => 1,
                    $lam25_700 => 1
                ],
                113 => [
                    32 => 1,
                    $lam25_700 => 2
                ],
                114 => [
                    32 => 1,
                    $lam25_700 => 1
                ],
                115 => [
                    32 => 1,
                    $lam25_700 => 2
                ],
                $softTouch30_1_0->getKey() => [
                    32 => 1,
                    $softTouch_700 => 1,
                ],
                $softTouch30_1_1->getKey() => [
                    32 => 1,
                    $softTouch_700 => 2,
                ]
            ],
            25 => [
                112 => [
                    32 => 1,
                    $lam25_900 => 1
                ],
                113 => [
                    32 => 1,
                    $lam25_900 => 2
                ],
                114 => [
                    32 => 1,
                    $lam25_900 => 1
                ],
                115 => [
                    32 => 1,
                    $lam25_900 => 2
                ],
                $softTouch30_1_0->getKey() => [
                    32 => 1,
                    $softTouch_900 => 1,
                ],
                $softTouch30_1_1->getKey() => [
                    32 => 1,
                    $softTouch_900 => 2,
                ]
            ],
        ];

        $calculators = CalculatorType::query()->where('name', 'booklets')
            ->first()->calculators;

        $calculators->each(function (Calculator $calculator) use ($printSpecieWorkAdditional) {
            foreach ($printSpecieWorkAdditional as $item) {
                foreach ($item as $workRepeats) {
                    foreach ($workRepeats as $workId => $repeat) {
                        PivotWorkAdditional::query()->where('calculator_id', $calculator->id)
                            ->where('work_additional_id', $workId)->delete();
                    }
                }
            }
        });

        $calculators->each(function (Calculator $calculator) use ($printSpecieWorkAdditional) {
            foreach ($printSpecieWorkAdditional as $printSpecie => $item) {
                foreach ($item as $laminationId => $workRepeats) {
                    foreach ($workRepeats as $workId => $repeat) {
                        PivotWorkAdditional::query()->create([
                            'work_additional_id' => $workId,
                            'lamination_id' => $laminationId,
                            'print_specie_id' => $printSpecie,
                            'calculator_id' => $calculator->id,
                            'repeat' => $repeat
                        ]);
                    }
                }
            }
        });
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
