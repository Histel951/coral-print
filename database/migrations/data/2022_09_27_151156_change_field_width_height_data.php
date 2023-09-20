<?php

use App\Models\CalculatorFieldsConfig;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $widthHeightValue = CalculatorFieldsConfig::query()->find(15)->value;

        $widthHeightValue['width_height'] = [
            'predefinedValues' => true
        ];

        CalculatorFieldsConfig::query()->find(15)->update([
            'value' => $widthHeightValue
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $widthHeightValue = CalculatorFieldsConfig::query()->find(15)->value;

        $widthHeightValue['width_height'] = [
            'predefinedValues' => true,
            'labelInnerText' => ''
        ];

        CalculatorFieldsConfig::query()->find(15)->update([
            'value' => $widthHeightValue
        ]);
    }
};
