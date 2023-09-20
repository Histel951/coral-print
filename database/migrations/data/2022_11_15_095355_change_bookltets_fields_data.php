<?php

use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\FormField;
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
        FormField::query()->find(3)->update([
            'parameters' => [
                'label' => 'Тираж',
                'default' => 300,
                'postText' => 'шт',
                'formField' => 'product_count',
                'numbersOnly' => true
            ]
        ]);

        $configSizeLabel = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height' => [
                    'label' => 'Размер'
                ]
            ]
        ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => 3867,
            'calculator_fields_config_id' => $configSizeLabel->getKey()
        ]);

        Calculator::query()->find(3867)->update([
            'svg_id' => 'leaflets-icon'
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
