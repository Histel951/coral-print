<?php

use App\Models\Calculator;
use App\Models\CalculatorType;
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
        $calculators = CalculatorType::query()->where('name', 'stickers')->first()->calculators;

        $isDepsDataCalculators = [
            $calculators->where('name', 'Круглые наклейки с логотипом')->first(),
            $calculators->where('name', 'Прямоугольные стикеры')->first(),
            $calculators->where('name', 'Овальные стикеры')->first(),
            $calculators->where('name', 'Фигурные стикеры')->first(),
            $calculators->where('name', 'Наборы стикеров')->first(),
            $calculators->where('name', 'Наклейки на машину')->first(),
            $calculators->where('name', 'Графика на стену')->first(),
            $calculators->where('name', 'Стикеры на стекло')->first(),
            $calculators->where('name', 'Надписи и аппликации')->first(),
            $calculators->where('name', 'Стикеры с печатью белым')->first(),
            $calculators->where('name', 'Наклейки с фольгой')->first()
        ];

        foreach ($isDepsDataCalculators as $calculator) {
            $this->updateParameters($calculator, ['is_deps_data' => true]);
        }

        $hasWhitePrintCalculators = [
            $calculators->where('name', 'Наборы стикеров')->first(),
            $calculators->where('name', 'Наклейки на машину')->first(),
            $calculators->where('name', 'Стикеры на стекло')->first(),
            $calculators->where('name', 'Объемные наклейки')->first()
        ];

        foreach ($hasWhitePrintCalculators as $calculator) {
            $this->updateParameters($calculator, ['has_white_print' => true]);
        }

        $hasVolumeCalculators = [
            $calculators->where('name', 'Наклейки с фольгой')->first(),
            $calculators->where('name', 'Стикеры с печатью белым')->first()
        ];

        foreach ($hasVolumeCalculators as $calculator) {
            $this->updateParameters($calculator, ['has_volume' => true]);
        }
    }

    private function updateParameters(Calculator $calculator, array $parameters): void
    {
        $calculator->update([
            'parameters' => Arr::collapse([
                $calculator->parameters,
                $parameters
            ])
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
