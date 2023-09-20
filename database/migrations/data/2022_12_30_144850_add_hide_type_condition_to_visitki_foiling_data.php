<?php

use App\Models\Calculator;
use Illuminate\Database\Migrations\Migration;
use App\Models\CalculatorType;
use App\Services\Calculator\CalculatorType as CalculatorTypeE;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculators = CalculatorType::query()->where('name', CalculatorTypeE::BusinessCards->value)->first()->calculators;

        $this->addHideTypeCondition($calculators->where('name', 'С фольгированием')->first());

        $calculators->where('name', 'VIP')->first()->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'material_wrapper' => [
                    'fields' => [
                        'color_count_face_visitki_vip_face_select' => [
                            'label' => 'Печать лицо'
                        ],
                        'color_count_back_visitki_vip_back_select' => [
                            'label' => 'Печать оборот'
                        ]
                    ]
                ]
            ]
        ]);

        $calculators->where('name', 'С фольгированием')->first()->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height' => [
                    'conditions' => [
                        'isUsePredefinedValues' => [
                            [
                                'field' => 'form',
                                'value' => [55]
                            ]
                        ],
                    ]
                ]
            ]
        ]);
    }

    private function addHideTypeCondition(Calculator $calculator): void
    {
        $calculator->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'product_count_types' => [
                    'conditions' => [
                        'countHideTypes' => [
                            [
                                'values' => [
                                    'form' => 55
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
    }
};
