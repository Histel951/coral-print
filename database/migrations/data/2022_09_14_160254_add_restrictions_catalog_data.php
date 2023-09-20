<?php

use App\Models\Calculator;
use App\Models\PivotPrintRestriction;
use App\Models\PivotPrintRestrictionMessage;
use App\Models\PrintRestriction;
use App\Models\PrintRestrictionMessage;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $catalogRestrictionPrints = [30, 31, 33, 34];
        $calculatorsPrintRestriction = [3856, 3858, 3859];

        foreach ($calculatorsPrintRestriction as $calculatorId) {
            foreach ($catalogRestrictionPrints as $printId) {
                PivotPrintRestriction::query()->create([
                    'specie_type_id' => $printId,
                    'calculator_id' => $calculatorId
                ]);
            }
        }

        $lastCalculatorCatalog = Calculator::query()->where('calculator_type_id', 3854)->latest()->first();
        $calculatorsStaticRestriction = [3855, 3860, 3866, $lastCalculatorCatalog->id];

        $newRestriction = PrintRestriction::query()->create([
            'width' => 218,
            'height' => 306,
            'min_width' => 10,
            'min_height' => 10
        ]);

        $newRestrictionMessage = PrintRestrictionMessage::query()->create([
            'error_field' => 'width_height',
            'message' => 'Мы можем печатать размером от #min_height#x#min_width# до #height#x#width#'
        ]);

        PivotPrintRestrictionMessage::query()->create([
            'print_restriction_id' => $newRestriction->getKey(),
            'print_restriction_message_id' => $newRestrictionMessage->getKey()
        ]);

        foreach ($calculatorsStaticRestriction as $calculatorId) {
            PivotPrintRestriction::query()->create([
                'calculator_id' => $calculatorId,
                'print_restriction_id' => $newRestriction->getKey()
            ]);
        }

        $newMessagePrints = [30, 31, 33, 34];
        foreach ($newMessagePrints as $printId) {
            PivotPrintRestrictionMessage::query()->create([
                'specie_type_id' => $printId,
                'print_restriction_message_id' => $newRestrictionMessage->getKey()
            ]);
        }
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
