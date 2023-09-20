<?php

use App\Models\CalculatorType;
use Illuminate\Database\Migrations\Migration;
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

        $calculators->where('name', 'На прозрачном пластике')->first()->fields()->create([
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
