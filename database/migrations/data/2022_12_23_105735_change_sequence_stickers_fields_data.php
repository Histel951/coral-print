<?php

use App\Models\Calculator;
use App\Models\FormField;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $foilingStickers = Calculator::query()->where('name', 'Наклейки с фольгой')->first();
        $casesStickers = Calculator::query()->where('name', 'Наборы стикеров')->first();

        $this->setSequence($foilingStickers, [
            'form' => 1,
            'diameter' => 2,
            'width_height' => 3,
            'product_count_types' => 4,
            'material' => 5,
            'lam' => 6,
            'foiling' => 7,
            'cutting' => 8
        ]);

        $this->setSequence($casesStickers, [
            'print_type' => 1,
            'width_height' => 2,
            'product_count_types' => 3,
            'material' => 4,
            'lam' => 5,
            'foiling' => 6
        ]);

        $calculators = Calculator::query()->whereIn('name', [
            'Стикеры с печатью белым',
            'Объемные наклейки',
            'Гарантийные стикеры'
        ]);

        $calculators->each(fn (Calculator $calculator) => $this->setSequence($calculator, [
            'form' => 1,
            'diameter' => 2,
            'width_height' => 3,
            'material' => 4,
            'cutting' => 5
        ]));
    }

    private function setSequence(Calculator $calculator, array $fieldsSequence): void
    {
        $calculator->fieldsSequence()->delete();
        foreach ($fieldsSequence as $fieldName => $sequence) {
            $field = FormField::query()->where('name', $fieldName)->first();

            $calculator->fieldsSequence()->create([
                'form_field_id' => $field->id,
                'sequence' => $sequence
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
