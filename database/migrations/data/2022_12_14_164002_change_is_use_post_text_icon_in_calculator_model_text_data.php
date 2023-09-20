<?php

use App\Models\Calculator;
use App\Models\CalculatorModelTextDataMessage;
use App\Models\PrintForm;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        CalculatorModelTextDataMessage::query()
            ->where('print_form_id', PrintForm::query()->whereIn('name', ['Овальная', 'Круглая', 'Сложная'])->first()->id)
            ->update([
                'is_use_post_text_icon' => false
            ]);

        $calculatorRoundRulone = Calculator::query()->where('name', 'Круглые этикетки в рулоне')->first();

        $calculatorRoundRulone->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height_flex' => [
                    'paddingDropdown' => '7px 0 0 16px'
                ]
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
    }
};
