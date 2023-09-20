<?php

use App\Models\CalculatorFieldsConfig;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Arr;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // "width_height": {"conditions": {"hidden": [{"field": "form", "value": 54}]}}
        $config = CalculatorFieldsConfig::query()->find(27);

        $config->update([
            'value' => Arr::collapse([
                $config->value,
                [
                    'width_height' => [
                        'conditions' => [
                            'hidden' => [
                                [
                                    'field' => 'form',
                                    'value' => 54
                                ],
                            ]
                        ]
                    ]
                ]
            ])
        ]);
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
