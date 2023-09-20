<?php

use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Models\Cutting;
use App\Models\Preview;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculatorsEticketok = CalculatorType::query()->where('name', 'labelsTag')->first()->calculators;
        $calculatorsStickers = CalculatorType::query()->where('name', 'stickers')->first()->calculators;

        $whitedStickers = $calculatorsStickers->where('name', 'Стикеры с печатью белым')->first();
        $whitedEticketki = $calculatorsEticketok->where('name', 'На листах с белилами')->first();

        $foilingStickers = $calculatorsStickers->where('name', 'Наклейки с фольгой')->first();
        $foilingEticketki = $calculatorsEticketok->where('name', 'На листах с фольгой')->first();

        $this->copyPreviews($whitedStickers, $whitedEticketki);
        $this->copyPreviews($foilingStickers, $foilingEticketki);
    }

    private function copyPreviews(Calculator $calculatorCurrent, Calculator $calculatorCopy): void
    {
        $cutting = Cutting::query()->where('name', 'С надсечкой на общей подложке')->first();
        $calculatorCurrent->previews()->where('cutting_id', $cutting->id)->where('is_volume', 0)->each(
            fn (Preview $preview) => $calculatorCopy->previews()->create([
                'calculator_type_id' => $calculatorCopy->calculatorType->id,
                'form_id' => $preview->form_id,
                'cutting_id' => $preview->cutting_id,
                'height' => $preview->height,
                'width' => $preview->width,
                'svg_id' => $preview->svg_id
            ])
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
