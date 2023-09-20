<?php

use App\Models\CalculatorFieldsConfig;
use App\Models\PivotCalculatorFieldsConfig;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height' => [
                    'labelInnerText' => ''
                ]
            ]
        ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => 3873,
            'calculator_fields_config_id' => $config->getKey()
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
