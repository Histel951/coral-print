<?php

use App\Models\FormField;
use App\Models\PivotCalculatorFoiling;
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
        foreach ([37 => 'foiling_face', 38 => 'foiling_back'] as $foilingId => $formMaterialField) {
            $foiling = FormField::query()->find($foilingId);
            $parameters = $foiling['parameters'];

            $parameters['formColorField'] = $formMaterialField . '_color';
            $parameters['formMaterialField'] = $formMaterialField;
            $foiling->update([
                'type' => 'radio-material',
                'parameters' => $parameters
            ]);
        }

        $vizitkyFoilings = [
            3832 => [
                [
                    'foilings' => [26, 27],
                    'is_face' => true,
                ],
                [
                    'foilings' => [25, 26, 27],
                    'is_face' => false,
                ]
            ],
            3833 => [
                [
                    'foilings' => [26, 27],
                    'is_face' => true,
                ],
                [
                    'foilings' => [25, 26, 27],
                    'is_face' => false,
                ]
            ]
        ];

        foreach ($vizitkyFoilings as $calculatorId => $foilings) {
            foreach ($foilings as $foiling) {
                foreach ($foiling['foilings'] as $foilingId) {
                    PivotCalculatorFoiling::query()->create([
                        'calculator_id' => $calculatorId,
                        'foiling_id' => $foilingId,
                        'is_face' => $foiling['is_face']
                    ]);
                }
            }
        }

        $workAdditionals = [
            'foiling_ids' => [26, 27],
            'material_id' => 46,
            'work_ids' => [31, 36]
        ];

        foreach ($workAdditionals['foiling_ids'] as $foilingId) {
            foreach ($workAdditionals['work_ids'] as $workId) {
                PivotWorkAdditional::query()->create([
                    'foiling_id' => $foilingId,
                    'work_additional_id' => $workId,
                    'material_id' => $workAdditionals['material_id']
                ]);
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
