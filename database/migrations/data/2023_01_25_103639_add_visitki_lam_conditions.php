<?php

use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\CalculatorType;
use App\Models\Material;
use App\Models\MaterialCategory;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $materials = MaterialCategory::query()->where('name', 'Дизайнерские бумаги')->first()->materials;
        $calculators = CalculatorType::query()->where('name', 'businessCards')->first()->calculators;

        $conditions = [];

        $materials->each(function (Material $material) use (&$conditions) {
            $conditions['readonlyMany'][] = [
                'values' => [
                    'material' => $material->id
                ]
            ];

            $conditions['selectedMany'][] = [
                'value' => 45,
                'values' => [
                    'material' => $material->id
                ]
            ];
        });

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'lam' => [
                    'conditions' => [
                        'readonlyMany' => $conditions['readonlyMany'],
                        'selectedMany' => $conditions['selectedMany']
                    ]
                ]
            ]
        ]);

        $calculators->each(fn (Calculator $calculator) => $calculator->fields()->attach($config->id));
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
