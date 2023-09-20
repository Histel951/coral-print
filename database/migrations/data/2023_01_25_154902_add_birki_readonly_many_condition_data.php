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
        $calculators = \App\Models\CalculatorType::query()->where('name', 'businessCards')->first()->calculators;

        $config = \App\Models\CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'material' => [
                    'conditions' => [
                        'readonlyItemsIn' => [
                            [
                                'change_field' => 'material',
                                'disabled_items' => [],
                                'field' => 'lam',
                                'values' => [111]
                            ],
                            [
                                'change_field' => 'material',
                                'disabled_items' => [],
                                'field' => 'foiling_face',
                                'values' => [25]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $calculators->each(fn (\App\Models\Calculator $calculator) => $calculator->fields()->attach($config->id));
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
