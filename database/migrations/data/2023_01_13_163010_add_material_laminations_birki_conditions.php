<?php

use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
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
        $calculators = CalculatorType::query()->where('name', CalculatorTypeE::Labels->value)->first()->calculators;

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'material' => [
                    'conditions' => [
                        'readonlyItemsIn' => [
                            [
                                'field' => 'lam',
                                'disabled_items' => [79, 82, 84, 85, 86, 87, 88, 89],
                                'change_field' => 'material',
                                'values' => [112, 113, 114, 115, 116, 119, 120]
                            ],
                            [
                                'field' => 'lam',
                                'disabled_items' => [79, 82, 84, 85, 87, 88, 89],
                                'change_field' => 'material',
                                'values' => [117]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $calculators->each(fn (Calculator $calculator) => $calculator->fields()->attach($config->getKey()));
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
