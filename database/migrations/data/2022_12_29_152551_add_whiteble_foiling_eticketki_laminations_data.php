<?php

use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Models\Lamination;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculatorsEticketki = CalculatorType::query()->where('name', \App\Services\Calculator\CalculatorType::labelsTag->value)->first()->calculators;
        $calculatorsStickers = CalculatorType::query()->where('name', \App\Services\Calculator\CalculatorType::Stickers->value)->first()->calculators;

        $whitebleStickers = $calculatorsStickers->where('name', 'Стикеры с печатью белым')->first();
        $whitebleEticketki = $calculatorsEticketki->where('name', 'На листах с белилами')->first();

        $this->copyLaminations($whitebleStickers, $whitebleEticketki);

        $foilingEticketki = $calculatorsEticketki->where('name', 'На листах с фольгой')->first();
        $foilingStickers = $calculatorsStickers->where('name', 'Наклейки с фольгой')->first();

        $this->copyLaminations($foilingStickers, $foilingEticketki);
    }

    private function copyLaminations(Calculator $calculatorCurrent, Calculator $calculatorCopy): void
    {
        $calculatorCurrent->laminations()->each(
            fn (Lamination $lamination) => $calculatorCopy->laminations()->attach($lamination->id)
        );
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
