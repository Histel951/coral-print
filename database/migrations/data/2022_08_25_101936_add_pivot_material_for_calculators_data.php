<?php

use App\Models\CalculatorFieldsConfig;
use App\Models\PivotCalculatorMaterial;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Arr;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            'calculators' => [3818],
            'materials' => [22,61,145,146,147,148,149,150,151]
        ];

        foreach ($data['calculators'] as $calculatorId) {
            foreach ($data['materials'] as $materialId) {
                PivotCalculatorMaterial::query()->create([
                    'calculator_id' => $calculatorId,
                    'material_id' => $materialId,
                    'print_id' => 14,
                    'is_white_print' => true
                ]);
            }
        }

        $tickersPrintWhiteMaterials = [22,61,145,146,147,148,149,150,151];

        PivotCalculatorMaterial::query()->where([
            'calculator_id' => 3819,
            'print_id' => 14
        ])->delete();

        foreach ($tickersPrintWhiteMaterials as $materialId) {
            PivotCalculatorMaterial::query()->create([
                'calculator_id' => 3819,
                'material_id' => $materialId,
                'print_id' => 14
            ]);
        }

        $stickersVolumeMaterials = [22,61,145,146,147,148,149,150,151];

        $config = CalculatorFieldsConfig::query()->find(17);

        $config->update([
            'value' => Arr::collapse([
                $config->value,
                [
                    'material' => [
                        'url' => 'http://coral-print.test/api/calculator/materials',
                        'deps' => ['print_type', 'white_print']
                    ]
                ]
            ])
        ]);

        foreach ($stickersVolumeMaterials as $materialId) {
            PivotCalculatorMaterial::query()->create([
                'calculator_id' => 3829,
                'print_id' => 14,
                'is_white_print' => true,
                'material_id' => $materialId
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
