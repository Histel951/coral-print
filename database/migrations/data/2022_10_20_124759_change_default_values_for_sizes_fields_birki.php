<?php

use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\PivotCalculatorFieldsConfig;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculatorsDefaultSize50 = Calculator::query()->whereIn('name', [
            'Круглые воблеры',
            'Воблеры сложной формы',
            'Круглые бирки',
            'Бирки сложной формы'
        ]);

        $calculatorsDefaultSize10 = Calculator::query()->whereIn('name', [
            'Простые воблеры',
            'Хенгеры',
            'Простые бирки'
        ]);

        $this->setDefaultSize($calculatorsDefaultSize10, 10);
        $this->setDefaultSize($calculatorsDefaultSize50, 50);
    }

    private function setDefaultSize(Builder $calculators, int $size): void
    {
        $calculators->each(function (Calculator $calculator) use ($size): void {
            $newConfig = CalculatorFieldsConfig::query()->create([
                'type' => 'fields_options',
                'value' => [
                    'width_height' => [
                        "defaultWidth" => $size,
                        "defaultHeight" => $size,
                    ],
                    'diameter' => [
                        'default' => $size,
                    ],
                ]
            ]);

            PivotCalculatorFieldsConfig::query()->create([
                'calculator_fields_config_id' => $newConfig->getKey(),
                'calculator_id' => $calculator->id
            ]);
        });
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
